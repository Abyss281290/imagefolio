<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Companies'=>array('index'),
	$model->name,
);
$this->title = 'Update Company';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>