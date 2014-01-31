<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Talents'=>array('/agency/models/admin'),
	$model->firstname.' '.$model->lastname,
	'Update',
);

$this->title = 'Update Talent';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>