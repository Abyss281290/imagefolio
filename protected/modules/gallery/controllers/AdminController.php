<?php

class AdminController extends CAdminController
{
		public $assetPath;
		
		public $galleryCodeTypes = array(
			0=>'gallery',
			1=>'polaroids',
			2=>'covers'
		);
	
	public function __construct($id, $module=null)
	{
		$this->assetPath = $module->assetPath;
		parent::__construct($id, $module);
	}
	
	public function accessRules()
	{
		return array(
			AgencyHelper::getAgencyPaidAccessRule(),
			array('allow',
				'actions'=>array('uploadify'),
				'users'=>array('*'),
			),
			array('allow',
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function renderView($gallerycode, $view, $data = null)
	{
		$galleryType = isset($this->galleryCodeTypes[$gallerycode])
			? $this->galleryCodeTypes[$gallerycode]
			: $this->galleryCodeTypes[0];
		$view = $this->getViewFile($galleryType.'/'.$view)
			? $galleryType.'/'.$view
			: $view;
		$this->render($view, $data);
	}
	
	public function actionIndex()
	{
		$this->_checkBeforeAction();
		$model = $this->loadGalleryModel();
		$this->_addAssets($model);
		$this->renderView($_REQUEST['gallerycode'], 'index', array(
			'model' => $model,
			'module' => $this->module
		));
	}
	
	public function actionDeleteImage()
	{
		if(isset($_REQUEST['id'])) {
			if($img = GalleryImage::model()->findByPk($_REQUEST['id'])) {
				$img->delete();
			}
		}
	}
	
	public function actionSetMainImage()
	{
		if(isset($_REQUEST['id'])) {
			if($img = GalleryImage::model()->findByAttributes(array('main'=>1))) {
				$img->main = 0;
				$img->update(array('main'));
			}
			if($img = GalleryImage::model()->findByPk($_REQUEST['id'])) {
				$img->main = 1;
				$img->update(array('main'));
			}
		}
	}
	
	public function actionPublishImage()
	{
		if(isset($_REQUEST['id'])) {
			if($img = GalleryImage::model()->findByPk($_REQUEST['id'])) {
				$img->public = !$img->public*1;
				$img->update(array('public'));
			}
		}
	}
	
	public function actionOrdering()
	{
		if(isset($_REQUEST['id'], $_REQUEST['order'])) {
			$_REQUEST['order'] = (int)$_REQUEST['order'];
			$model = GalleryImage::model()->findByPk($_REQUEST['id']);
			if($model && $model->ordering != $_REQUEST['order']) {
				$db =& Yii::app()->db;
				$db->createCommand("UPDATE {{galleries_images}} SET ordering = ordering - 1 WHERE ordering > ".$model->ordering." AND gallery_id = ".$model->gallery_id)->execute();
				$db->createCommand("UPDATE {{galleries_images}} SET ordering = ordering + 1 WHERE ordering >= ".$_REQUEST['order']." AND gallery_id = ".$model->gallery_id)->execute();
				$model->ordering = $_REQUEST['order'];
				$model->update(array('ordering'));
			}
		}
	}
	
	public function actionViewCrop()
	{
		if(isset($_REQUEST['id'])) {
			$id = (int)$_REQUEST['id'];
			$model = GalleryImage::model()->findByPk($id);
			if(!$model)
				throw new CHttpException(404, 'Image #'.$id.' not found');
			
			$this->layout = '//layouts/none';
			
			$this->renderView($model->gallerycode, 'crop', array(
				'model' => $model
			));
			die();
		}
	}
	
	/*public function actionAjaxDoCrop()
	{
		if(isset($_REQUEST['image_id']))
		{
			$r = $_REQUEST;
			$r['image_id'] = (int)$r['image_id'];
			$img = GalleryImage::model()->findByPk($r['image_id']);
			$icc = $img->crop_data;
			if(
				$img
				&& isset($r['x'], $r['y'], $r['x2'], $r['y2'], $r['w'], $r['h'])
				&& (
						$icc['x'] != $r['x']
						|| $icc['y'] != $r['y']
						|| $icc['x2'] != $r['x2']
						|| $icc['y2'] != $r['y2']
						|| $icc['w'] != $r['w']
						|| $icc['h'] != $r['h']
					)
			) {
				$img->crop($r);
			}
		}
		die();
	}*/
	public function actionAjaxDoCrop($image_id)
	{
		if(Yii::app()->request->isAjaxRequest) {
			$img = GalleryImage::model()->findByPk($image_id);
			if($img) {
				$img->cropZoom($_POST);
				die();
			}
		}
	}
	
	public function actionViewCropTempFile()
	{
		$r = $_REQUEST;
		if(isset($r['gallerycode'], $r['filename'], $r['fieldNum'])) {
			$this->layout = '//layouts/none';
			$this->renderView($r['gallerycode'], 'crop_tempfile', array(
				'crop_data' => $r
			));
			die();
		}
	}
	
	public function actionUploadTemp()
	{
		$m = $this->module;
		$response = array(
			'loaded' => false,
			'error' => 'Error',
			'filename' => '',
			'uploadedFilename' => '',
			'thumb' => '',
		);
		if($file = CUploadedFile::getInstanceByName('file'))
		{
			if(!in_array(strtolower($file->getExtensionName()), array('jpg','jpeg','png','gif'))) {
				$response['loaded'] = false;
				$response['error'] = 'Error: incorrect file extension';
			} else {
				$mediaPath = $m->tmpPath;
				$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$mediaPath;
				Yii::app()->image->createImagesDirectory($filename_path);
				$filename = time() . '_' . $file->getName();
				$thumbName = 'thumb_'.$filename;
				// save original
				if($file->saveAs($path = $filename_path . DIRECTORY_SEPARATOR . $filename, false)) {
					$imageSize = getimagesize($path);
					if(is_array($m->originalImageSize)) {
						if($imageSize[0] > $m->originalImageSize[0]) {
							$img = Yii::app()->image->load($path);
							$img->resize($m->originalImageSize[0], $m->originalImageSize[1], $m->originalImageSize[3]);
							$img->quality($m->originalImageSize[2]);
							$img->save();
						}
					}
					$response['loaded'] = true;
					$response['filename'] = $file->getName();
					$response['uploadedFilename'] = $filename;
					// make thumbnail
					if($file->saveAs($path = $filename_path . DIRECTORY_SEPARATOR . $thumbName)) {
						$img = Yii::app()->image->load($path);
						$img->resize(75, 100);
						$img->save();
						$response['thumb'] = Yii::app()->baseUrl.'/'.$mediaPath.'/'.$thumbName;
					}
				} else {
					$response['loaded'] = false;
					$response['error'] = 'Error: '.$file->getError();
				}
			}
		}
		echo CJSON::encode($response);
		die();
	}
	
	public function actionAjaxCropTempImage()
	{
		$r = $_REQUEST;
		Yii::import('ext.cropzoom.JCropZoom');
		$tmpPath = Yii::getPathOfAlias('webroot').'/'.$this->module->tmpPath;
		$filepath = $tmpPath.'/'.$r['filename'];
		$r['imageSource'] = $filepath;
		JCropZoom::getHandler()->process($r, $filepath);
		$img = Yii::app()->image->load($filepath);
		$img->resize(75, 100);
		$img->save($tmpPath.'/thumb_'.$r['filename']);
		die();
	}
	
	public function actionUpload()
	{
		$this->_checkBeforeAction();
		
		// remove old temp files
		$tmpPath = Yii::getPathOfAlias('webroot').'/'.$this->module->tmpPath;
		if(is_dir($tmpPath) && ($dir = opendir($tmpPath))) {
			while(($file = readdir($dir)) !== false) {
				if(!in_array($file, array('.','..'))) {
					if(($time = @filemtime($tmpPath.'/'.$file)) && time() - $time > 60*60*24) {
						@unlink($tmpPath.'/'.$file);
					}
				}
			}
		}
		
		if(count($_POST)) {
			$model = $this->loadGalleryModel();
			//$model->attributes=$_POST['Gallery'];
			if($model->save() && $this->_processUpload($model)) {
				/*if($model->returnUrl) {
					$this->redirect($model->returnUrl);
				}*/
				$this->redirect(array(
					'index',
					'scope' => $model->scope,
					'item_id' => $model->item_id,
					'gallerycode' => $model->gallerycode,
					'returnUrl' => urlencode($model->returnUrl)
				));
			}
		}
		
		$this->renderView($model->gallerycode, 'index', array(
			'model' => $model,
			'module' => $this->module
		));
	}
	
	private function _createDirectory($path)
	{
		Yii::app()->image->createImagesDirectory($path);
	}
	
	private function _processUpload($model)
	{
		//set_time_limit(0);
		
		$m = $this->module;
		$tempDir = Yii::getPathOfAlias('webroot').'/'.$m->tmpPath;
		$galleriesPath = Yii::getPathOfAlias('webroot').'/'.$m->galleriesPath;
		$currentGalleryPath = $galleriesPath.'/'.$model->scope.'/'.$model->item_id;
		
		$this->_createDirectory($galleriesPath);
		$this->_createDirectory($galleriesPath.'/'.$model->scope);
		$this->_createDirectory($galleriesPath.'/'.$model->scope.'/'.$model->item_id);
		foreach(array_keys($m->getSizes($model->scope)) as $size)
			$this->_createDirectory($currentGalleryPath.'/'.$size);
		
		if (isset($_POST['uploaded_files']) && count($_POST['uploaded_files']))
		{
			foreach ($_POST['uploaded_files'] as $image => $pic)
			{
				$originalPath = $tempDir.'/'.$pic;
				
				// maybe tmp image is missing, then skip
				if(!is_file($originalPath))
					continue;
				
				$fileParts  = pathinfo($pic);
				$fileParts['extension'] = strtolower($fileParts['extension']);
				$newImgName = $model->id.'_'.md5(time()).$image.'.'.$fileParts['extension'];
				
				// save as original image
				//copy($originalPath, $currentGalleryPath.'/'.$newImgName);
				
				$gimg = new GalleryImage();
				$gimg->gallery_id = $model->id;
				$gimg->src = $newImgName;
				$gimg->srcSource = $newImgName;
				$gimg->ordering = $model->maxOrdering+$image+1;
				
				if(!empty($_POST['uploaded_files_coords'][$image])) {
					$coords = array();
					parse_str($_POST['uploaded_files_coords'][$image], $coords);
					$gimg->crop_data = @serialize($coords);
				}
				$gimg->makeImageSizes($originalPath, $newImgName);
				$gimg->save();
				
				/*if(!empty($_POST['uploaded_files_coords'][$image])) {
					$coords = array();
					parse_str($_POST['uploaded_files_coords'][$image], $coords);
					$gimg->cropZoom($coords);
				} else {
					// generate different image sizes
					$gimg->makeImageSizes($originalPath, $newImgName);
				}*/
				// remove temp image
				@unlink($originalPath);
				@unlink($tempDir.'/thumb_'.$pic);
			}
		}
		return true;
	}
	
	public function loadModel($id)
	{
		$model = new Gallery();
		$item = $model->findByPk($id);
		if($item === null)
			throw new CHttpException(404,'Item not found');
		return $item;
	}
	
	public function loadGalleryModel()
	{
		return Gallery::loadFromRequest();
	}
	
	public function _addAssets($model)
	{
		Yii::import('system.web.helpers.CJSON');
		Yii::app()->clientScript->registerCoreScript('jquery');
				
		//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/colorbox/jquery.colorbox-min.js');
		//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js/colorbox/colorbox.css');
		$this->widget('ext.colorbox.JColorBox');
		
		Yii::app()->clientScript->registerCssFile($this->assetPath.'/css/admin.css');
		Yii::app()->clientScript->registerScriptFile($this->assetPath.'/js/admin.js');
		$js = "
			Gallery.gallery_id = ".(int)$model->id.";
			Gallery.gallerycode = ".(int)$_REQUEST['gallerycode'].";
			Gallery.urls = ".CJSON::encode(array(
				'base' => Yii::app()->baseUrl,
				'remove' => $this->createUrl('deleteImage'),
				'setMainImage' => $this->createUrl('setMainImage'),
				'publishImage' => $this->createUrl('publishImage'),
				'viewCrop' => $this->createUrl('viewCrop'),
				'viewCropTempFile' => $this->createUrl('viewCropTempFile'),
				'uploadTemp' => $this->createUrl('uploadTemp')
		));
		Yii::app()->clientScript->registerScript('Gallery.preload', $js);
		Yii::app()->clientScript->registerScript('Gallery.init', "Gallery.init()");
	}
	
	private function _checkBeforeAction()
	{
		if(!isset($_REQUEST['scope'], $_REQUEST['item_id'], $_REQUEST['returnUrl']))
				throw new CHttpException(404,'Gallery not found. Check request params [scope, item_id, returnUrl] - must be given');
	}
}