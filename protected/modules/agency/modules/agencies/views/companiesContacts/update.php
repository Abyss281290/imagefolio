<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Contacts'=>array('index'),
	$model->name
);
$this->title = 'Update Contact';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>