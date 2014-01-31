<?php
class KeepaliveWidget extends CWidget
{
		public $interval = 300; // seconds (default 5 min)
		
	public function init()
	{
		$this->interval = (int)$this->interval * 1000;
		Yii::app()->getClientScript()->registerScript(
			'keepalive',
			'setInterval(function(){ $.ajax("'.Yii::app()->homeUrl.'") }, '.$this->interval.');'
		);
	}
}