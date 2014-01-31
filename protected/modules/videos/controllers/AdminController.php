<?php

class AdminController extends CAdminController
{
	
		public $assetPath;
	
	public function __construct($id, $module=null)
	{
		$this->assetPath = $module->assetPath;
		parent::__construct($id, $module);
	}
	
	public function actionIndex()
	{
		$this->_checkBeforeAction();
		$this->_addAssets();
		$model = $this->loadVideosModel();
		$this->render('index', array(
			'model' => $model,
			'module' => $this->module
		));
	}
	
	public function actionViewVideoItem($id)
	{
		$this->layout = 'none';
		$model = VideosItems::model()->findByPk($id);
		$this->render('viewVideoItem', array(
			'model' => $model,
			'module' => $this->module
		));
		die();
	}
	
	public function actionRemove()
	{
		if(isset($_REQUEST['id'])) {
			VideosItems::model()->findByPk($_REQUEST['id'])->delete();
		}
	}
	
	public function actionOrdering()
	{
		if(isset($_REQUEST['id'], $_REQUEST['order'])) {
			$_REQUEST['order'] = (int)$_REQUEST['order'];
			$model = VideosItems::model()->findByPk($_REQUEST['id']);
			if($model && $model->ordering != $_REQUEST['order']) {
				$db =& Yii::app()->db;
				$db->createCommand("UPDATE {{videos_items}} SET ordering = ordering - 1 WHERE ordering > ".$model->ordering." AND video_id = ".$model->video_id)->execute();
				$db->createCommand("UPDATE {{videos_items}} SET ordering = ordering + 1 WHERE ordering >= ".$_REQUEST['order']." AND video_id = ".$model->video_id)->execute();
				$model->ordering = $_REQUEST['order'];
				$model->save();
			}
		}
	}
	
	public function actionUpload()
	{
		$this->_checkBeforeAction();
		$model = $this->loadVideosModel();
		if(count($_POST)) {
			//$model->attributes=$_POST['Gallery'];
			if($model->save() && $this->_processUpload($model)) {
				$this->redirect(array(
					'index',
					'scope' => $model->scope,
					'item_id' => $model->item_id,
					'returnUrl' => urlencode($model->returnUrl)
				));
			}
		}
		$this->_addAssets();
		$this->render('index', array(
			'model' => $model,
			'module' => $this->module
		));
	}
	
	private function _createDirectory($path)
	{
		Yii::app()->image->createImagesDirectory($path);
	}
	
	private function _processUpload(&$model)
	{
		set_time_limit(0);
		
		$m = $this->module;
		$galleriesPath = Yii::getPathOfAlias('webroot').'/'.$m->galleriesPath;
		$currentGalleryPath = $galleriesPath.'/'.$model->scope.'/'.$model->item_id;
		$videoPath = $currentGalleryPath.'/videos';
		$imagesPath = $currentGalleryPath.'/images';
		
		$this->_createDirectory($galleriesPath);
		$this->_createDirectory($galleriesPath.'/'.$model->scope);
		$this->_createDirectory($galleriesPath.'/'.$model->scope.'/'.$model->item_id);
		$this->_createDirectory($videoPath);
		$this->_createDirectory($imagesPath);
		
		$newName = $model->id.'_'.md5(time());
		
		if($file = CUploadedFile::getInstance($model, 'video')) {
			$file->saveAs($videoPath.'/'.$newName.'.flv'/*.$file->getExtensionName()*/);
			
			if($file = CUploadedFile::getInstance($model, 'image')) {
				$originalPath = $imagesPath.'/'.$newName.'.jpg';
				$file->saveAs($originalPath);
				$img = Yii::app()->image->load($originalPath);
				$sizeParams = $m->thumbnailSize += array(100, 100, 100);
				$img->resize($sizeParams[0], $sizeParams[1], Image::WIDTH);
				$img->quality($sizeParams[2]);
				$img->save($imagesPath.'/'.$newName.'_thumb.jpg');
			}
			
			$item = new VideosItems();
			$item->video_id = $model->id;
			$item->src = $newName;
			$item->ordering = $model->maxOrdering+1;
			$item->save();
		}
		
		return true;
	}
	
	public function loadVideosModel()
	{
		return Videos::loadFromRequest();
	}
	
	public function _addAssets()
	{
		Yii::import('system.web.helpers.CJSON');
		Yii::app()->clientScript->registerCoreScript('jquery');
				
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/colorbox/jquery.colorbox-min.js');
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js/colorbox/colorbox.css');
		
		Yii::app()->clientScript->registerCssFile($this->assetPath.'/css/admin.css');
		Yii::app()->clientScript->registerScriptFile($this->assetPath.'/js/admin.js');
		$js = "Gallery.urls = ".CJSON::encode(array(
			'remove' => $this->createUrl('deleteImage')
		));
		Yii::app()->clientScript->registerScript('Gallery.preload', $js);
	}
	
	private function _checkBeforeAction()
	{
		if(!isset($_REQUEST['scope'], $_REQUEST['item_id'], $_REQUEST['returnUrl']))
				throw new CHttpException(404,'Gallery not found. Check request params [scope, item_id, returnUrl] - must be given');
	}
}