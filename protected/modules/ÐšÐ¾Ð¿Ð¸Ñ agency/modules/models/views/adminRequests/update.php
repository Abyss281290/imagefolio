<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Models Requests'=>array('index'),
	$model->name
);

$this->title = 'Update Request';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>