<?php

class ContentModule extends CWebModule
{
		public $imagesPath = 'images/content';
		// imageResize (array) or (false) if need no resize
		public $imageResize = array(
			'width' => 154,
			'height' => 126,
			'quality' => 95
		);
		public $title = 'Content';
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'content.models.*',
			'content.helpers.*'
		));
		
		$this->imagesPath = trim($this->imagesPath, '/');
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public static function t($text)
	{
		return Yii::t('content', $text);
	}
}