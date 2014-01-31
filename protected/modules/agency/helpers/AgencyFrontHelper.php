<?php

class AgencyFrontHelper
{
	/**
	 * (object) agency model OR (int) agency id
	 */
	public static function initAgency($mixedAgency)
	{
		$app = Yii::app();
		$controller = $app->controller;
		
		if(is_numeric($mixedAgency)) {
			$mixedAgency = Agencies::model()->findByPk($mixedAgency);
		}
		
		if(!$mixedAgency)
			return false;
		
		// theme
		$app->setTheme(
			$mixedAgency->color_site
				? $mixedAgency->color_site
				: current(AgenciesHelper::getThemeColors())
		);
		//layout
		$controller->layout = '//layouts/agency';
		// set agency to registry
		$app->params->agency = $mixedAgency;
		// menu
		$items = array();
		
		//$items[] = array('label'=>'Home', 'url'=>$controller->createUrl('/agency/agencies/default/view',array('id'=>$mixedAgency->id)));
		if($mixedAgency->isPaid()) {
			$tmp = array();
			foreach($mixedAgency->menu as $menu) {
				$tmp[$menu->parent_id][$menu->id] = array(
					'label'=>$menu->type->title,
					'url'=>$controller->createUrl('/agency/models/default/index', array(
						'agency_id'=>$menu->agency_id,
						'type_id'=>$menu->type_id
					)),
					'active'=>$controller->id == 'default' && $controller->action->id == 'index' && $app->request->getParam('type_id') == $menu->type_id
				);
			}
			foreach($tmp as $parent_id => $menus) {
				if($parent_id == 0) {
					foreach($menus as $id => $menu) {
						$index = count($items);
						$items[$index] = $menu;
						if(isset($tmp[$id])) {
							$items[$index]['items'] = $tmp[$id];
						}
					}
				}
			}
		}
		$items[] = array('label'=>'About', 'url'=>$controller->createUrl('/agency/agencies/default/about',array('agency_id'=>$mixedAgency->id)));
		$items[] = array('label'=>'Contact', 'url'=>$controller->createUrl('/agency/agencies/default/contact',array('agency_id'=>$mixedAgency->id)));
		if($mixedAgency->isPaid() && $mixedAgency->plan->submissions)
			$items[] = array('label'=>'Apply', 'url'=>$controller->createUrl('/agency/models/requests/create', array('agency_id'=>$mixedAgency->id)));

		if($items) {
			$controller->menu = array('items'=>$items);
		}
		
		// set logo
		if($mixedAgency->image->exists) {
			$controller->logo['image'] = $mixedAgency->image->full;
		}
		$controller->logo['url'] = $controller->createUrl('/agency/agencies/default/view',array('id'=>$mixedAgency->id));
		
		return true;
	}
}

?>