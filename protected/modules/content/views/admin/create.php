<?php
$this->breadcrumbs=array(
	$this->module->title=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List '.$this->module->title, 'url'=>array('index')),
	array('label'=>'Manage '.$this->module->title, 'url'=>array('admin')),
);

$this->title = 'Create '.$this->module->title;
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>