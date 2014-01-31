<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Clients'=>array('index'),
	'Create',
);
$this->title = 'Create Client';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>