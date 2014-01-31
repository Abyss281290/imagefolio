<?php

class ModelsModule extends CWebModule
{
	public $videosPath = 'images/models_videos';
	public $videosSize = array(500, 375);
	public $videosAllowedTypes = 'flv'; // 'flv, avi, mpeg'
	
	public $requestsImagesPath = 'images/models_requests';
	public $requestsImagesThumbsSize = array('width'=>130,'height'=>170,'quality'=>90);
	//
	
	public $assetPath;
	
	public function init()
	{
		$this->setImport(array(
			$this->id.'.models.*',
			$this->id.'.helpers.*'
		));
		
		$this->assetPath = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets', false, -1, YII_DEBUG);
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}