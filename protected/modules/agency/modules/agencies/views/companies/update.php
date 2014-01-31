<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Clients'=>array('index'),
	$model->name,
);
$this->title = 'Update Client';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>