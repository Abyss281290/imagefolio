<?php

class RequestsController extends Controller
{
	public function accessRules()
	{
		return array(
			array('deny',
				//'actions'=>array('register', 'registerDone'),
				'expression'=>function() {
					if(isset($_REQUEST["agency_id"])) {
						$aid = (int)$_REQUEST['agency_id'];
						if($agency = AgencyModule::getAgency($aid)) {
							return $agency->isPaid() == false || AgencyModule::isAgencyHasPlanOption("submissions", $aid) == false;
						}
					}
				}
			)
		);
	}
	
	public function actionAjaxLoadCharacteristics($request_id, $type_id)
	{
		$model = ModelsRequests::model()->findByPk($request_id);
		if(!$model)
			$model = ModelsRequests::model();
		$this->renderPartial('create_characteristics',array(
			'model'=>$model,
			'type'=> AgencyTypes::model()->findByPk($type_id),
			//'type2'=> AgencyTypes::model()->findByPk($type2_id),
		), false, true);
	}
	
	/*public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ModelsRequests');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/
	
	public function actionCreate($agency_id)
	{
		$agency = Agencies::model()->findByPk($agency_id);
		if($agency===null)
			throw new CHttpException(404,'The requested page does not exist.');
		AgencyFrontHelper::initAgency($agency);
		$model = new ModelsRequests();
		$model->agency_id = $agency_id;
		
		$agencyParentMenuTypes = AgencyMenus::model()->findAll('agency_id=:aid AND parent_id = 0', array('aid'=>$agency_id));
		if(isset($_POST['ModelsRequests']))
		{
			$model->attributes=$_POST['ModelsRequests'];
			if($model->save())
				$this->redirect(array('done', 'agency_id'=>$agency_id));
		}
		
		$this->render('create',array(
			'agency'=>$agency,
			'model'=>$model,
			'agencyParentMenuTypes'=>$agencyParentMenuTypes
		));
	}
	
	public function actionUploadTempImage()
	{
		$model = new ModelsRequests();
		$m = $this->module;
		$response = array(
			'loaded' => false,
			'error' => 'Error',
			'filename' => '',
			'uploadedFilename' => '',
			'thumb' => '',
		);
		if(count($_FILES) && ($name = key($_FILES[key($_FILES)]['name'])) && ($file = CUploadedFile::getInstance($model,$name)))
		{
			if(in_array($file->getExtensionName(), array('jpeg','jpg','png','gif')))
			{
				$mediaPath = $m->tmpPath;
				$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$mediaPath;
				Yii::app()->image->createImagesDirectory($filename_path);
				$filename = uniqid(time().'_').$file->getName();
				$thumbName = 'thumb_'.$filename;
				// save original
				if($file->saveAs($path = $filename_path . DIRECTORY_SEPARATOR . $filename, false)) {
					$imageSize = getimagesize($path);
					/*if(is_array($m->originalImageSize)) {
						if($imageSize[0] > $m->originalImageSize[0]) {
							$img = Yii::app()->image->load($path);
							$img->resize($m->originalImageSize[0], $m->originalImageSize[1], $m->originalImageSize[3]);
							$img->quality($m->originalImageSize[2]);
							$img->save();
						}
					}*/
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
			else
			{
				$response['loaded'] = false;
				$response['error'] = 'Error: invalid extension';
			}
		}
		echo CJSON::encode($response);
		die();
	}
	
	public function actionViewCropTempFile()
	{
		$r = $_REQUEST;
		if(isset($r['filename'], $r['fileFieldId'])) {
			$this->layout = '//layouts/none';
			$this->render('crop_tempfile', array(
				'crop_data' => $r
			));
			die();
		}
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
	
	public function actionDone($agency_id)
	{
		$agency = Agencies::model()->findByPk($agency_id);
		if($agency===null)
			throw new CHttpException(404,'The requested page does not exist.');
		//$model = $this->loadModel($request_id);
		AgencyFrontHelper::initAgency($agency);
		CHtml::refresh(10, $this->createUrl('create',array('agency_id'=>$agency_id)));
		$this->render('done',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ModelsRequests::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
