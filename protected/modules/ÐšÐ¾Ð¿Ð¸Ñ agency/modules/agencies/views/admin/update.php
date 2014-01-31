<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Agencies'=>array('index'),
	$model->full_name=>array('update','id'=>$model->id),
	'Update',
);

$this->title = 'Update Agency';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>