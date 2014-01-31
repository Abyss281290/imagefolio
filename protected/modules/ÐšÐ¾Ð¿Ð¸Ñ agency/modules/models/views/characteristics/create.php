<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Characteristics'=>array('index'),
	'Create',
);

$this->title = 'Create Characteristic';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>