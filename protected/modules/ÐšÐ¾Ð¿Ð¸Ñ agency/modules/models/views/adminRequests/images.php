<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Models Requests'=>array('index'),
	$model->name=>array('update','id'=>$model->id),
	'Images'
);

$this->title = 'Request Images';

$this->widget('ext.colorbox.JColorBox')->addInstance('a[rel=models-requests]');
?>
<?php foreach(array('image_head_shot','image_mid_length','image_full_length') as $attribute): ?>
<?php echo CHtml::link(CHtml::image($model->$attribute->thumb), $model->$attribute->full, array('rel'=>'models-requests')); ?>
<?php endforeach; ?>