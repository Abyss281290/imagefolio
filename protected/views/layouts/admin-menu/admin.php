<?php
return array(
	array('label'=>'Users', 'url'=>array('/admin/admin')),
	array('label'=>Yii::app()->getModule('content')->title, 'url'=>array('/content/admin/index')),
	array('label'=>'Agency', 'url'=>'#', 'items'=>array(
		//array('label'=>'Agencies', 'url'=>array('/agency/agencies/admin/index')),
		//array('label'=>'Models', 'url'=>array('/agency/models/admin/index')),
		array('label'=>'Types', 'url'=>array('/agency/models/types')),
		array('label'=>'Characteristics', 'url'=>array('/agency/models/characteristics')),
	)),
	array('label'=>'Payment Packages', 'url'=>array('/agency/agencies/plans/index'), 'items'=>array(
		array('label'=>'Invoices', 'url'=>array('/agency/agencies/invoices/index')),
	)),
	//array('label'=>'Invoices', 'url'=>array('/agency/agencies/invoices/index')),
	array('label'=>'Agencies', 'url'=>array('/agency/agencies/admin/index')),
	array('label'=>'Talents', 'url'=>array('/agency/models/admin/index'), 'items'=>array(
		array('label'=>'Images View', 'url'=>array('/agency/models/admin/index')),
		array('label'=>'Listing View', 'url'=>array('/agency/models/admin/index/view/list')),
	)),
	array('label'=>'Talents Requests', 'url'=>array('/agency/models/adminRequests/index')),
	array('label'=>'Packages', 'url'=>array('/agency/models/adminPackages/index'), 'items'=>array(
		array('label'=>'Reports', 'url'=>array('/agency/models/packagesReports/index')),
		//array('label'=>'Simple Reports', 'url'=>array('/agency/models/packagesReports/simple')),
	)),
	array('label'=>'Bookers', 'url'=>array('/agency/agencies/bookers/index')),
	array('label'=>'Clients', 'url'=>array('/agency/agencies/companies/index'), 'items'=>array(
		array('label'=>'Contacts', 'url'=>array('/agency/agencies/companiesContacts/index')),
	)),
	array('label'=>'Config', 'url'=>array('/config/index')),
);