<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Bookers'=>array('index'),
	'Create',
);
$this->title = 'Create Booker';
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>