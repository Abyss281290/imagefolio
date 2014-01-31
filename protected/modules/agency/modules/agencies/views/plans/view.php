<?php
$this->breadcrumbs=array(
	'Agency Plans'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List AgencyPlans', 'url'=>array('index')),
	array('label'=>'Create AgencyPlans', 'url'=>array('create')),
	array('label'=>'Update AgencyPlans', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AgencyPlans', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AgencyPlans', 'url'=>array('admin')),
);
?>

<h1>View AgencyPlans #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'models_allowed',
		'price',
		'additional_model_price',
		'images_allowed',
	),
)); ?>
