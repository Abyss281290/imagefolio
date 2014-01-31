<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Invoices'=>array('index'),
	'View #'.$model->id
);

$this->title = 'View invoice #'.$model->id;

$user = Yii::app()->user;
?>
<style type="text/css">
	.items thead tr th {
		background: #eee;
		padding: 5px 3px;
	}
	.items tr.total {
		background: #eee;
	}
	.items tr.total .price {
		font-weight: bold;
	}
</style>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agencies-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'validateOnType' => false,
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data'
	),
)); ?>
<?php
$attributes = array();
if($user->isAdmin()) {
	$attributes[] = array(
		'name'=>'agency',
		'value'=>$model->agency->full_name
	);
}
$attributes[] = array(
	'name'=>'paid',
	'value'=>Yii::app()->format->booleanTick($model->paid)
			.($user->isAdmin()
				? ($model->paid
					? CHtml::link('Make unpaid', $this->createUrl('makePaid',array('invoice_id'=>$model->id)),array('class'=>'button red', 'style'=>'margin-left: 10px'))
					: CHtml::link('Make paid', $this->createUrl('makePaid',array('invoice_id'=>$model->id)),array('class'=>'button green', 'style'=>'margin-left: 10px'))
				)
				: ''
			),
	'type'=>'raw'
);
$attributes[] = array(
	'name'=>'payment_type',
	'value'=>$model->paymentTypeLabel
);
$attributes[] = 'paid_time';
$attributes[] = 'create_time';

if($user->isAdmin()) {
	// check count of invoices of this month
	$count = AgencyInvoices::model()->agency($model->agency_id)->count("create_time >= CONCAT( YEAR(CURDATE()), '-', MONTH(CURDATE()), '-01 00:00:00' )");
	if($count > 1) {
		$attributes[] = array(
			'name'=>'removed',
			'value'=>$form->checkBox($model, 'removed'),
			'type'=>'raw'
		);
	}
} else {
	$attributes[] = array(
			'name'=>'removed',
			'type'=>'booleanTick'
		);
}

$attributes[] = 'id';
if($user->isAdmin()) {
	$attributes[] = array(
		'name'=>'comments',
		'value'=>$form->textArea($model, 'comments', array('cols'=>150,'rows'=>10))
			.'<div>'.CHtml::submitButton('Save', array('class' => 'button blue')).'</div>',
		'type'=>'raw'
	);
} else {
	$attributes[] = array(
		'name'=>'comments',
		'type'=>'nText'
	);
}
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>$attributes,
));
?>
<?php
if($model->items):
	$invoiceItem = AgencyInvoicesItems::model();
?>
<fieldset>
	<legend>Invoice items</legend>
	<table class="items">
		<thead>
			<tr>
				<th><?php echo $invoiceItem->getAttributeLabel('title'); ?></th>
				<th><?php echo $invoiceItem->getAttributeLabel('description'); ?></th>
				<th><?php echo $invoiceItem->getAttributeLabel('price'); ?></th>
			</tr>
		</thead>
		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>new CArrayDataProvider($model->items,array('pagination'=>false)),
			'ajaxUpdate'=>false,
			'template'=>'{items}',
			'itemView'=>'_view',
			'pager'=>array(
				'maxButtonCount'=>'7',
			),
			'sortableAttributes'=>array(
				'firstname',
				'lastname',
				'birthyear'
			),
		)); ?>
		<tfoot>
			<tr class="total">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="price"><?php echo '$'.number_format($model->price,2); ?></td>
			</tr>
		</tfoot>
	</table>
</fieldset>
<?php endif; ?>
<?php $this->endWidget(); ?>