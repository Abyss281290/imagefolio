<?php
class AgenciesModule extends CWebModule
{
		public $logosPath = 'images/agencies/logo';
		public $bannersPath = 'images/agencies/banners';
		public $splashesPath = 'images/agencies/splashes';
		
		// imageResize (array) or (false) if need no resize
		public $logoResize = array(
			'width' => 250,
			'height' => 73,
			'quality' => 95,
			'master' => 3, // @see "extensions/image/Image.php" constants
		);
		public $bannerResize = array(
			'width' => 250,
			'height' => 150,
			'quality' => 95,
			'master' => 4, // @see "extensions/image/Image.php" constants
		);
		public $assetPath;
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'agencies.models.*',
			'agencies.components.*',
			'agencies.helpers.*',
		));
		
		$this->logosPath = trim($this->logosPath, '/');
		$this->assetPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias($this->id).'/assets', false, -1, YII_DEBUG);
		
		/*Yii::app()->setComponents(
			array('messages' => array(
				'class'=>'CPhpMessageSource',
				'basePath'=>'/protected/modules/agency/modules/agencies/messages',
			))
		);*/
	}
	
	public static function t($message, $plural = 1, $category = 'AgencyModule/main')
	{
		$params = array($plural);
		return Yii::t($category, $message);
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
}