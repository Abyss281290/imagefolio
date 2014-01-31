<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Packages'=>array('index'),
	$model->title
);

$this->title = 'Update Package';

$this->addTrigger('Send this package',$this->createUrl('send',array('id'=>$model->id)));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php echo $this->renderPartial('_items', array('model'=>$model)); ?>