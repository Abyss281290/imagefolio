<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Payment Packages',
	'Update'
);
$this->title = 'Update Package';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>