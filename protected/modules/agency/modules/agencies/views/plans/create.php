<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Payment Packages',
	'Create'
);
$this->title = 'Create Package';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>