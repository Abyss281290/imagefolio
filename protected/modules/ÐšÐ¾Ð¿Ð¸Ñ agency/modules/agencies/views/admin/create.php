<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Agencies'=>array('index'),
	'Create',
);

$this->title = 'Create Agency';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>