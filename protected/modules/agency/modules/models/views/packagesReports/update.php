<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Packages'=>array('adminPackages/index'),
	'Reports'=>array('index'),
	$model->package->title
);

$this->title = 'Update Report';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>