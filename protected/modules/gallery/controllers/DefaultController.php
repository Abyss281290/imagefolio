<?php

class DefaultController extends Controller
{
		public $basePath;
	
	public function __construct($id, $module=null)
	{
		$this->basePath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('gallery'));
		
		parent::__construct($id, $module);
	}
	
	public function actionIndex()
	{
		$model = Gallery::loadFromRequest();
		$this->render('index', array(
			'model' => $model
		));
	}
	
	public function _addAssets()
	{
		
		Yii::app()->clientScript->registerCssFile($this->basePath.'/assets/style.css');
	}
}