<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Models Requests'=>array('index'),
	'Create',
);

$this->title = 'Create Request';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>