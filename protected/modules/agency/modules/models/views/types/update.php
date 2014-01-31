<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Types'=>array('index'),
	$model->title
);

$this->title = 'Update Type';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>