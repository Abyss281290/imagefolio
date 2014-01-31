<?php

class AgencyHelper
{
	public static function getAgencyPaidAccessRule($actions = array())
	{
		$rule = array('deny',
			'roles'=>array('agency','booker'),
			'expression'=>'AgencyModule::getAgency()->isPaid() == false'
		);
		if(count($actions))
			$rule['actions'] = $actions;
		return $rule;
	}
	
	public static function & getAgenciesIdTitle()
	{
		$items = Agencies::model()->findAll(array('order' => 'full_name'));
		$re = array();
		foreach($items as $item)
			$re[$item->id] = $item->full_name;
		return $re;
	}
}

?>
