<?php
class uploadifyWidget extends CInputWidget
{
		protected $assetPath;
		
		public $options = array();
		public $jsOptions = array();
		
	public function init()
	{
		$this->assetPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets', false , -1, YII_DEBUG);
		
		$cs = Yii :: app()->getClientScript();
		$cs->registerScriptFile($this->assetPath.'/swfobject.js');
		$cs->registerScriptFile($this->assetPath.'/jquery.uploadify.min.js');
		$cs->registerCssFile($this->assetPath.'/uploadify.css');
		
		(array)$this->jsOptions += array(
			'uploader' => $this->assetPath.'/uploadify.swf',
			'script' => Yii::app()->controller
							? Yii::app()->controller->createUrl('uploadify')
							: Yii::app()->createUrl('/site/uploadify'),
			//'script' => $this->assetPath.'/uploadify.php',
			'cancelImg' => $this->assetPath.'/cancel.png',
			'auto' => false,
			'multi' => true,
			'fileExt' => '*.jpg;*.jpeg;*.gif;*.png',
			'queueID' => 'uploadify_queue',
			'onError' => "js:function(event,ID,fileObj,errorObj)
			{
				alert(errorObj.type + ' Error: ' + errorObj.info);
			}",
			'onComplete' => "js:function(event, ID, fileObj, response, data)
			{
				if(response == 'invalid extension')
					alert(response);
				else
					$('#uploadify_uploaded_files').append('<input type=\"hidden\" name=\"uploaded_files[]\" value=\"'+response+'\">');
			}",
			'onAllComplete' => "js:function(event, data)
			{
				alert(data.filesUploaded + ' files uploaded successfully!');
			}"
		);
	}
	
	public function run() {
		$this->render('uploadifyWidget', array(
			'jsOptions' => CJavaScript::encode($this->jsOptions),
		));
	}
	
	public function button()
	{
		return '<div id="uploadify"></div>';
	}
	
	public function queue()
	{
		return '
			<div id="uploadify_queue"></div>
			<div id="uploadify_uploaded_files" style="display: none"></div>
		';
	}
}