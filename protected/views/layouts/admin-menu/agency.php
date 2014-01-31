<?php
$menu = array();
$menu[] = array('label'=>'My Agency', 'url'=>array('/agency/agencies/admin/update/', 'id'=>Yii::app()->user->agency_id));
$menu[] = array('label'=>'Payment Packages', 'url'=>array('/agency/agencies/plans/select'), 'items'=>array(
	array('label'=>'Invoices', 'url'=>array('/agency/agencies/invoices/index')),
));
$menu[] = array('label'=>'My Talents', 'url'=>array('/agency/models/admin/index'), 'items'=>array(
	array('label'=>'Images View', 'url'=>array('/agency/models/admin/index')),
	array('label'=>'Listing View', 'url'=>array('/agency/models/admin/index/view/list')),
));
//$menu[] = array('label'=>'Agency Menu', 'url'=>array('/agency/agencies/menus/index/', 'agency_id'=>Yii::app()->user->agency_id));
$menu[] = array('label'=>'Talents Requests', 'url'=>array('/agency/models/adminRequests/index'));
if(AgencyModule::isAgencyHasPlanOption('packages')) {
	$menu[] = array('label'=>'Packages', 'url'=>array('/agency/models/adminPackages/index'), 'items'=>array(
		array('label'=>'Reports', 'url'=>array('/agency/models/packagesReports/index')),
		array('label'=>'Simple Reports', 'url'=>array('/agency/models/packagesReports/simple')),
	));
}
$menu[] = array('label'=>'Bookers', 'url'=>array('/agency/agencies/bookers/index'));
$menu[] = array('label'=>'Clients', 'url'=>array('/agency/agencies/companies/index'), 'items'=>array(
	array('label'=>'Contacts', 'url'=>array('/agency/agencies/companiesContacts/index')),
));
return $menu;