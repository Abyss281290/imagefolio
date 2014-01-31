<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Contacts'=>array('index'),
	'Create',
);
$this->title = 'Create Contact';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>