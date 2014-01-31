<?php

class VideosModule extends CWebModule
{
		public $galleriesPath = 'images/videos'; // path of galleries
		public $thumbnailSize = array(200,115,90);
		//public $showNoimageDummy = false; // show no image pic if image doesnt exist
		
		public $videoSize = array(500, 375);
		
		public $scopeConfig = array(); // scopeName => ( sizeName => (width, height, quality) )
		
		public $assetPath;
	
	public function init()
	{
		$this->setImport(array(
			$this->id.'.models.*'
		));
		
		// process module config
		foreach($this->scopeConfig as $k => $v) {
			if(isset($this->$k) && $k != 'scopeConfig') {
				$this->$k = $v;
			}
		}
		$this->galleriesPath = trim($this->galleriesPath, '/');
		
		// else
		$this->assetPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('videos').'/assets', false, -1, YII_DEBUG);
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
	
	public function getAdminRoute($scope, $item_id, $returnUrl = '')
	{
		return Yii::app()->createUrl('/videos/admin/index', array(
			'scope' => $scope,
			'item_id' => $item_id,
			'returnUrl' => urlencode($returnUrl)
		));
	}
}
