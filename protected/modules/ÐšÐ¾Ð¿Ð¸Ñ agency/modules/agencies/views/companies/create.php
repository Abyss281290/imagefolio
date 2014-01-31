<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Companies'=>array('index'),
	'Create',
);
$this->title = 'Create Company';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>