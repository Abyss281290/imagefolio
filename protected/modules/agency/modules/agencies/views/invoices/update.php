<?php
$this->breadcrumbs=array(
	'Agency Invoices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AgencyInvoices', 'url'=>array('index')),
	array('label'=>'Create AgencyInvoices', 'url'=>array('create')),
	array('label'=>'View AgencyInvoices', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AgencyInvoices', 'url'=>array('admin')),
);
?>

<h1>Update AgencyInvoices <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>