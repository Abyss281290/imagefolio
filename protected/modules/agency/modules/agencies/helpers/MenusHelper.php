<?php
class MenusHelper
{
	public static function getDropDownListTreeData($agency_id, $active = true)
	{
		$agencyMenus = AgencyMenus::model()->findAll(
			array(
				'condition'=>'agency_id=:aid AND type.active='.(int)$active,
				'params'=>array(':aid'=>$agency_id),
				'with'=>array('type')
			)
		);
		$menus = array();
		foreach($agencyMenus as $item) {
			$menus[$item->parent_id][] = $item;
		}
		$options = array();
		foreach($menus[0] as $item) {
			$options[$item->type->id] = $item->type->title;
			if(isset($menus[$item->id])) {
				foreach($menus[$item->id] as $item2) {
					$options[$item2->type->id] = str_repeat('.', 10).$item2->type->title;
				}
			}
		}
		return $options;
	}
}
