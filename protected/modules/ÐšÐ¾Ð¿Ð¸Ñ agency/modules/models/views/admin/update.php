<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Models'=>array('/agency/models/admin'),
	$model->firstname.' '.$model->lastname,
	'Update',
);

$this->title = 'Update Models';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>