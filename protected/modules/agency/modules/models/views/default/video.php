<?php
$this->widget('ext.videoPlayer.Player', array(
	'src' => $model->video->full,
	'width' => $this->module->videosSize[0],
	'height' => $this->module->videosSize[1],
));
?>