<?php
class AgencyModule extends CWebModule
{
		public $assetPath;
	
	public function init()
	{
		$this->setImport(array(
			$this->id.'.models.*',
			$this->id.'.helpers.*',
			$this->id.'.modules.models.models.*',
			$this->id.'.modules.agencies.models.*',
		));
		
		$this->setModules(array('agencies', 'models'));
		
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
