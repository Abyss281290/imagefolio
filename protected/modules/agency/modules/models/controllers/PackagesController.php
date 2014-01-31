<?php

class PackagesController extends Controller
{
	public function actionView($hash)
	{
		$model = $this->loadModelByHash($hash);
		$model->incrementViews();
		AgencyFrontHelper::initAgency($model->owningAgency);
		$this->render('view',array(
			'model'=>$model
		));
	}
	
	public function actionModel($package_hash, $model_id)
	{
		$package = $this->loadModelByHash($package_hash);
		$model = Models::model()->findByPk($model_id);
		$items = $package->getImagesItems($model_id);
		$gallery = Gallery::model()->findByAttributes(array(
			'scope' => 'models',
			'item_id' => $model_id,
			'gallerycode' => 0
		));
		AgencyFrontHelper::initAgency($package->owningAgency);
		$this->render('model',array(
			'package'=>$package,
			'model'=>$model,
			'items'=>$items
		));
	}
	
	public function loadModelByHash($hash)
	{
		if(strval($hash)==='' || ($model=ModelsPackages::model()->findByAttributes(array('hash'=>$hash)))===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModel($id)
	{
		$model=ModelsPackages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
