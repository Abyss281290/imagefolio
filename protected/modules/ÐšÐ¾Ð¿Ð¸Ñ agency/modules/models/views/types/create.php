<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Types'=>array('index'),
	'Create',
);

$this->title = 'Create Type';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>