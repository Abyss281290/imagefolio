<?php
$menu = array();
$menu[] = array('label'=>'My Profile', 'url'=>array('/agency/agencies/bookers/update/', 'id'=>Yii::app()->user->booker_id));
$menu[] = array('label'=>'My Talents', 'url'=>array('/agency/models/admin/index'), 'items'=>array(
	array('label'=>'Images View', 'url'=>array('/agency/models/admin/index')),
	array('label'=>'Listing View', 'url'=>array('/agency/models/admin/index/view/list')),
));
$menu[] = array('label'=>'Talents Requests', 'url'=>array('/agency/models/adminRequests/index'));
if(AgencyModule::isAgencyHasPlanOption('packages')) {
	$menu[] = array('label'=>'Packages', 'url'=>array('/agency/models/adminPackages/index'), 'items'=>array(
		array('label'=>'Reports', 'url'=>array('/agency/models/packagesReports/index')),
		array('label'=>'Simple Reports', 'url'=>array('/agency/models/packagesReports/simple')),
	));
}
$menu[] = array('label'=>'Clients', 'url'=>array('/agency/agencies/companies/index'), 'items'=>array(
	array('label'=>'Contacts', 'url'=>array('/agency/agencies/companiesContacts/index')),
));
return $menu;