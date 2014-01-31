<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Packages'=>array('index'),
	'Create',
);
$this->title = 'Create Package';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>