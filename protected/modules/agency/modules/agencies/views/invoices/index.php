<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Invoices'
);

$this->title = 'Invoices';

Yii::import('ext.geo.GeoHelper');
$user = Yii::app()->user;
?>
<style type="text/css">
	.items td {
		vertical-align: top;
	}
	.items tfoot .total {
		font-weight: bold;
		text-shadow: 2px 2px 2px #ccc;
		padding: 2px;
		border-bottom: 1px solid #777;
	}
	table.invoice-items {
		
	}
	table.invoice-items tr {
		background: none;
	}
	table.invoice-items td {
		border: none !important;
		padding: 0 !important;
	}
	table.invoice-items td.title {
		padding-right: 5px !important;
	}
	table.invoice-items td.price {
		width: 20%;
	}
</style>
<script type="text/javascript">
function installDatepicker()
{
	$(
		'#AgencyInvoices_filter_create_time_from'
		+', #AgencyInvoices_filter_create_time_to'
		+', #AgencyInvoices_filter_paid_time_from'
		+', #AgencyInvoices_filter_paid_time_to'
	).datepicker(<?php echo CJSON::encode(array(
		'changeMonth'=>true,
		'changeYear'=>true,
		'showOn'=>'focus'
)); ?>);
}
$(installDatepicker);
$(document).ajaxComplete(installDatepicker);
</script>
<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> */ ?>
<?php
$viewUrl = 'Yii::app()->controller->createUrl("view",array("id"=>$data->id))';
$columns = array();
$columns[] = array(
	'class'=>'ButtonColumn',
	'header'=>'Action',
	//'template'=>'{menus}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{active}{unactive}',
	'template'=>'{view}',
	'viewButtonUrl'=>$viewUrl
);
if($user->isAdmin()) {
	$columns[] = array(
		'name'=>'agency_id',
		'value'=>'$data->agency->full_name',
		'filter'=>AgencyHelper::getAgenciesIdTitle()
	);
}
$columns[] = array(
	'header'=>'Invoice items',
	'value'=>'Yii::app()->controller->renderPartial("_index_items",array("data"=>$data))',
	'htmlOptions'=>array(
		'width'=>'25%'
	)
);
$columns[] = array(
	'name'=>'price',
	//'filter'=>false,
	'value'=>'"$".number_format($data->price,2)',
	'footer'=>'Paid:&nbsp;<span class="total">$'.number_format($invoicesTotalPaid,2).'</span>'
		.'<br />Unpaid:&nbsp;<span class="total">$'.number_format($invoicesTotalUnpaid,2).'</span>'
		
);
$columns[] = array(
	'name'=>'paid',
	'type'=>'booleanTick',
	'filter'=>array('No','Yes'),
	'htmlOptions'=>array('class'=>'center')
);
$columns[] = array(
	'name'=>'payment_type',
	'value'=>'$data->paymentTypeLabel',
	'filter'=>$model->getPaymentTypeLabels()
);
$columns[] = array(
	'name'=>'paid_time',
	'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'filter_paid_time_from',
			'htmlOptions'=>array(
				'style'=>'width:70px'
			),  
		),true)
		.'<br />'.$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'filter_paid_time_to',
			'htmlOptions'=>array(
				'style'=>'width:70px'
			),  
		),true),
	'htmlOptions'=>array(
		'style'=>'width: 25%'
	)
);
$columns[] = array(
	'name'=>'create_time',
	'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'filter_create_time_from',
			'htmlOptions'=>array(
				'style'=>'width:70px'
			),  
		),true)
		.'<br />'.$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'filter_create_time_to',
			'htmlOptions'=>array(
				'style'=>'width:70px'
			),  
		),true),
	'htmlOptions'=>array(
		'style'=>'width: 25%'
	)
);
$columns[] = array(
	'name'=>'removed',
	'type'=>'booleanTick',
	'filter'=>array('No','Yes'),
	'htmlOptions'=>array('class'=>'center')
);
$columns[] = array(
	'name'=>'id',
	'htmlOptions'=>array(
		'width'=>'1%'
	)
);

$this->widget('ext.grid.GridView', array(
	'id'=>'agency-invoices-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>$columns,
)); ?>
<?php
if($user->isAgency() && ($agency=AgencyModule::getAgency()) && !$agency->isPaid(false, false)):
	$paymentConfig = AgencyModule::getPaymentConfig();
?>
<div class="right">
	<?php echo CHtml::beginForm('https://secure.internetsecure.com/process.cgi', 'post'); ?>
	<?php //echo CHtml::hiddenField('GatewayID', $paymentConfig['GatewayID']); ?>
	<?php echo CHtml::hiddenField('MerchantNumber', $paymentConfig['MerchantNumber']); ?>
	<?php //echo CHtml::hiddenField('Token', 123); ?>
	<?php echo CHtml::hiddenField('ReturnCGI', $this->createAbsoluteUrl('index',array('success'=>1))); ?>
	<?php echo CHtml::hiddenField('xxxCancelURL', $this->createAbsoluteUrl('index',array('cancel'=>1))); ?>
	<?php //echo CHtml::hiddenField('xxxCustomerDB', '1'); ?>
	<?php //echo CHtml::hiddenField('email', 'asdada@dasda.ds'); ?>
	<?php echo CHtml::hiddenField('Products', $invoicesTotalUnpaid.'::1::001::Invoice'.($paymentConfig['testMode']?'::{TEST}':'')); ?>
	<?php echo CHtml::hiddenField('xxxName', $agency->owner_name); ?>
	<?php echo CHtml::hiddenField('xxxCompany', $agency->full_name); ?>
	<?php echo CHtml::hiddenField('xxxAddress', $agency->address); ?>
	<?php echo CHtml::hiddenField('xxxCity', GeoHelper::getSingleValue("cities", $agency->city_id)); ?>
	<?php echo CHtml::hiddenField('xxxPhone', $agency->telephone); ?>
	<?php echo CHtml::hiddenField('xxxEmail', $agency->owner_email); ?>
	<?php echo CHtml::hiddenField('agency_id', $agency->id); ?>
	<?php echo CHtml::submitButton('Pay', array('class'=>'button blue')); ?>
	<?php //echo CHtml::link('Pay', array('pay'), array('class'=>'button blue')); ?>
	<?php echo CHtml::endForm(); ?>
</div>
<?php endif; ?>