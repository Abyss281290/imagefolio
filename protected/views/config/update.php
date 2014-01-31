<?php
$this->breadcrumbs=array(
	'Config'=>array('index'),
	$model->key,
);
$this->title = 'Update var';
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>