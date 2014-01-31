<?php
$this->breadcrumbs=array(
	'Agency Menuses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AgencyMenus', 'url'=>array('index')),
	array('label'=>'Create AgencyMenus', 'url'=>array('create')),
	array('label'=>'View AgencyMenus', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AgencyMenus', 'url'=>array('admin')),
);
?>

<h1>Update AgencyMenus <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>