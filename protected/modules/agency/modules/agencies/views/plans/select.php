<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Payment Packages'
);
$this->title = 'Payment Packages';
?>
<style type="text/css">
.items tr.active td {
	background: #BCE774;
	text-shadow: 1px 1px 1px #fff;
	font-weight: bold;
}
.items tr.active td span {
	text-shadow: none;
	font-weight: normal;
}
.description {
	
}
.description h2 {
	margin: 15px 0 5px;
}
</style>
<div class="description">
All ImageFolio hosting Options include the website, each Option allows varying numbers of Talents and images for each Talent to be hosted on ImageFolio, all Options have PDF MiniBooks and Video for each Talent. Option 2, 3, 4 & 5 include the email broadcast package system, allowing you to send via the website customised collections of talents portfolios including large numbers of images both set for public and non-public view. Options 3, 4 & 5 additionally include the talent applicant submission system that is a great improvement over receiving and managing talent applications via email.
Please select the most suitable Option for your agency, these can be upgraded at any time, and downgraded at the end of the current month.
</div>
<?php
$columns = array();
if($agency->isPaid(false, false)) {
	$columns[] = array(
		'type'=>'raw',
		'value'=>'
			'.$agency->plan_id.' == $data->id
				? "<span>&nbsp;</span>"
				: CHtml::link("Buy",Yii::app()->controller->createUrl("confirmSelect",array("plan_id"=>$data->id)),array("class"=>"button blue nowrap"))
		',
		'htmlOptions'=>array('style'=>'width: 1px; text-align: center')
	);
} else {
	Yii::app()->user->addFlashWarning('plans-pay-invoices', 'You must pay all invoices before you can select packages');
}
$columns[] = array(
	'name'=>'title',
	'htmlOptions'=>array('class'=>'bold')
);
$columns[] = 'models_allowed';
$columns[] = array(
	'name'=>'price',
	'value'=>'"$".number_format($data->price,2)'
);
$columns[] = array(
	'name'=>'website',
	'type'=>'booleanTick',
	'htmlOptions'=>array('class'=>'center')
);
$columns[] = array(
	'name'=>'packages',
	'type'=>'booleanTick',
	'htmlOptions'=>array('class'=>'center')
);
$columns[] = array(
	'name'=>'submissions',
	'type'=>'booleanTick',
	'htmlOptions'=>array('class'=>'center')
);
$columns[] = 'images_allowed';
$this->widget('ext.grid.GridView', array(
	'id'=>'agency-plans-grid',
	'dataProvider'=>$dataProvider,
	'rowCssClassExpression'=>'$this->rowCssClass[$row % count($this->rowCssClass)].($data->id == '.$agency->plan_id.'? " active" : "")',
	//'filter'=>$model,
	'columns'=>$columns,
)); ?>
<div class="description">
	<h2>Upgrades, downgrades and cancelling the service.</h2>
When you upgrade, you are credited, pro-rata for the amount of unused time for that month and asked to pay for the month ahead at the new rate.
When you downgrade an account, you will be charged at the lower rate at the end of the current month.
If you wish to cancel the service, all you need do is ignore and not pay the next invoice; your website admin page will become instantly inaccessible and account automatically terminated after a period of 14 days with no amounts outstanding.

	<h2>Questions.</h2>
If you have any questions at all, please do not hesitate contacting us.
</div>