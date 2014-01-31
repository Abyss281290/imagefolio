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
		$this->assetPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.videoPlayer.assets'), false, -1, YII_DEBUG);
		
		if(!$this->src)
			$this->src = $this->assetPath.'/test-video.flv';
		
		$this->htmlOptions += array(
			//'src'=>'http://jquery.lukelutman.com/plugins/flash/example.swf',
			'src' => $this->assetPath.'/uflvplayer_500x375.swf',
			'movie' => $this->assetPath.'/uflvplayer_500x375.swf',
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