<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Characteristics'=>array('index'),
	$model->title=>array('update','id'=>$model->id),
	'Update',
);

$this->title = 'Update Characteristic';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>