<?php

class Player extends CWidget
{
		public $src = '';
		public $pic = '';
		public $width = 500;
		public $height = 375;
		public $comment = '';
		
		public $htmlOptions = array();
		
		public $assetPath;
	
	public function init()
	{
		$module = Yii::app()->getModule('videos');
		$this->assetPath = $module->assetPath;
		
		if(!$this->src)
			$this->src = $this->assetPath.'/player/test-video.flv';
		
		$this->htmlOptions += array(
			//'src'=>'http://jquery.lukelutman.com/plugins/flash/example.swf',
			'src' => $this->assetPath.'/player/uflvplayer_500x375.swf',
			'movie' => $this->assetPath.'/player/uflvplayer_500x375.swf',
			'width' => $this->width,
			'height' => $this->height,
			'allowFullScreen' => true,
			'allowScriptAccess' => 'always',
			'bgcolor' => '#5E7EF2',
			'flashvars' => array(
				'way' => $this->src,
				'pic' => $this->pic,
				'tools' => 2,
				'skin' => 'black',
				'q' => 0,
				'volume' => 100,
				'comment'=> $this->comment,
			)
		);
		
		$this->widget('application.extensions.flash.EJqueryFlash',
			array(
				'name'=>'flash2',
				'text'=>'You must install Flash Player first',
				'htmlOptions'=>$this->htmlOptions
			)
		);
	}
}