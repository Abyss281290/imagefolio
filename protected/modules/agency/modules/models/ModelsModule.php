<?php

class ModelsModule extends CWebModule
{
	public $videosPath = 'images/models_videos';
	public $videosSize = array(500, 375);
	public $videosAllowedTypes = 'flv, avi, mpeg, mpg, mp4'; // 'flv, avi, mpeg'
	
	public $requestsImagesPath = 'images/models_requests';
	public $requestsImagesThumbsSize = array('width'=>45,'height'=>85,'quality'=>90,'master'=>'height');
	//
	public $tmpPath = 'images/tmp';
	
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