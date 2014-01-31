<?php
class GalleryModule extends CWebModule
{
		public $assetPath;
		public $galleriesPath = 'images/galleries'; // path of galleries
		public $tmpPath = 'images/tmp';
		// sizeName => (width, height, quality) OR false if no resize needed (just save)
		public $defaultSizes = array(
			'small' => array(50,50,95),
			'medium' => array(200,115,90),
			'large' => array(700,550,85),
		);
		public $scopeSizes = array(); // scopeName => ( sizeName => (width, height, quality) )
		public $backendThumbsSize = 'medium'; // use this sizeName in backend preview
		public $frontendThumbsSize = 'medium'; // use this sizeName in frontend preview
		public $showNoimageDummy = false; // show no image pic if image doesnt exist
		// false - do not resize
		// array(width, height, quality)
		// @see "extensions/image/Image.php" constants
		//public $originalImageSize = array(1600, 1200, 100, 4);
		public $originalImageSize = false;
		//public $afterCropResize = array(340,450,95,2);
		
		// limit of images per gallery
		public $imagesLimitPerGallery = 10;
		
		// noimage dummy
		public $noImage;
	
	public function init()
	{
		$this->setImport(array(
			$this->id.'.models.*'
		));
		
		$this->assetPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('gallery').'/assets', false, -1, YII_DEBUG);
		$this->galleriesPath = trim($this->galleriesPath, '/');
		$this->tmpPath = trim($this->tmpPath, '/');
		$this->noImage = $this->assetPath.'/images/noimage.png';
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
	
	public function getAdminRoute($scope, $item_id, $returnUrl = '',$gallerycode=0)
	{
		return Yii::app()->createUrl('/gallery/admin/index', array(
			'scope' => $scope,
			'item_id' => $item_id,
			'gallerycode' => $gallerycode,
			'returnUrl' => urlencode($returnUrl)
		));
	}
	
	public function getSizes($scope = null)
	{
		$scope = $scope === null
			? (isset($_REQUEST['scope'])? $_REQUEST['scope'] : '')
			: $scope;
		return isset($this->scopeSizes[$scope])? $this->scopeSizes[$scope] : $this->defaultSizes;
	}
}
