<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Models'=>array('/agency/models/admin'),
	'Create',
);

$this->title = 'Create Models';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>