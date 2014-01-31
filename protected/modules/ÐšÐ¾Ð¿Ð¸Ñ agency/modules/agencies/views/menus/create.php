<?php
$this->breadcrumbs=array(
	'Agency Menuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AgencyMenus', 'url'=>array('index')),
	array('label'=>'Manage AgencyMenus', 'url'=>array('admin')),
);
?>

<h1>Create AgencyMenus</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>