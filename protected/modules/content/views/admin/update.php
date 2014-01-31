<?php
$this->breadcrumbs=array(
	$this->module->title=>array('index'),
	$model->name
);

$this->title = 'Update '.$this->module->title;
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>