
<?php
return array(
	array('label'=>'My Agency', 'url'=>array('/agency/agencies/admin/update/', 'id'=>Yii::app()->user->agency_id)),
	array('label'=>'Payment Packages', 'url'=>array('/agency/agencies/plans/select'), 'items'=>array(
		array('label'=>'Invoices', 'url'=>array('/agency/agencies/invoices/index')),
	)),
);