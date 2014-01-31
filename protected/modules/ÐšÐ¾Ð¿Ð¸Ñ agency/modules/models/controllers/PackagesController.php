<?php

class PackagesController extends Controller
{
	public function actionView($hash)
	{
		$model = $this->loadModelByHash($hash);
		$this->render('view',array(
			'model'=>$model
		));
	}
	
	public function loadModelByHash($hash)
	{
		$model=ModelsPackages::model()->findByAttributes(array('hash'=>$hash));
		if($model===null)
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
