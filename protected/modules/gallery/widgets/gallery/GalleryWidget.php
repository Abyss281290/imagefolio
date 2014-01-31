<?php

class GalleryWidget extends CWidget
{
		public $scope;
		public $item_id;
		
		public $module;
		public $assetPath;
	
	public function init()
	{
		$this->module = Yii::app()->getModule('gallery');
		$this->assetPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets', false , -1, YII_DEBUG);
		
		$cs = Yii :: app()->getClientScript();
		$cs->registerScriptFile($this->assetPath.'/js/jquery.jcarousel.pack.js');
		$cs->registerScriptFile($this->assetPath.'/js/gallery.js');
		$cs->registerCssFile($this->assetPath.'/css/jquery.jcarousel.css');
		$cs->registerCssFile($this->assetPath.'/css/skin.css');
		
		$c = new CDbCriteria();
		$gallery = Gallery::model()->findByAttributes(array(
			'scope' => $this->scope,
			'item_id' => $this->item_id
		));
		
		$this->render('view', array(
			'gallery' => $gallery
		));
	}
}