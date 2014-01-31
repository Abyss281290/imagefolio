<?php

class AgencyHelper
{
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
