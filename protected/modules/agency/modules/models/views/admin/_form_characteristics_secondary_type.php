<?php
$menus = array();

$c = new CDbCriteria();
$c->with = 'type';
$c->limit = 1;
$c->addColumnCondition(array('agency_id'=>$model->agency->id,'parent_id'=>0, 'type.id'=>$type_id));
$parent_menu = AgencyMenus::model()->find($c);
if($parent_menu) {
	$c = new CDbCriteria();
	$c->addColumnCondition(array('agency_id'=>$model->agency->id, 'parent_id'=>$parent_menu->id));
	$menus = AgencyMenus::model()->findAll($c);
}

echo CHtml::activeDropDownList(
	$model,
	'type2_id',
	CHtml::listData($menus,'type.id','type.title'),
	array('empty'=>'- Not selected -')
);
?>