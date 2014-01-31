<?php
$this->breadcrumbs=array(
	'Agency Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AgencyInvoices', 'url'=>array('index')),
	array('label'=>'Manage AgencyInvoices', 'url'=>array('admin')),
);
?>

<h1>Create AgencyInvoices</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>