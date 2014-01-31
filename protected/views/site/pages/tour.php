<?php
$model = ContentHelper::loadModel(3);
//$this->title = $model->title;
$this->title = 'Tour';
?>
<div class="agency-terms wysiwyg-content">
	<h3>Underneath tour video.</h3>

<?php
$this->widget('ext.videoPlayer.Player', array(
	'src' => Yii::app()->baseUrl.'/images/tour.flv',
	'width' => 640,
	'height' => 480,
));
?>
<p style="margin-top: 10px;">
To get ImageFolio for your agency start by completing the form <?php echo CHtml::link('here', $this->createAbsoluteUrl('/agency/agencies/default/register')); ?>,<br />
if you have any further questions or wish to discuss customization feel free to contact us <?php echo CHtml::link('here', $this->createAbsoluteUrl('/site/contact')); ?>.
</p>
	<?php //echo $model->content; ?>
</div>