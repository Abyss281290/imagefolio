<html lang="en-us">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
	<meta charset="utf-8" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/columnal/columnal.css" type="text/css" media="screen" />
</head>
<body>
<?php
	$this->widget('application.modules.videos.widgets.Player', array(
		'src' => $model->video->path,
		'pic' => $model->image->fullPath,
		'width' => $module->videoSize[0],
		'height' => $module->videoSize[1],
		'comment' => ''
	));
?>
</body>
</html>