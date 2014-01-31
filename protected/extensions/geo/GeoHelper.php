<?php
class GeoHelper
{
	public static function getData($what, $parent_id = null, $id = 0)
	{
		$db = Yii::app()->db;
		
		switch($what)
		{
			case 'countries':
				$key = 'Code';
				$value = 'Name';
				break;
			case 'cities':
			default:
				$key = 'id';
				$value = 'Name';
				break;
		}
		
		$where = array();
		if($parent_id !== null) {
			switch($what) {
				case 'cities':
					$where[] = "CountryCode = ".$db->quoteValue($parent_id);
					break;
			}
		}
		if($id)
			$where[] = "`$key` = ".$db->quoteValue($id);
		$where[] = 'active = 1';
		$where = $where? 'WHERE '.implode(' AND ', $where) : '';
		
		$sql = "SELECT *, `$key` AS `key`, `$value` AS `value` FROM {{geo_$what}} $where ORDER BY `order`, `$value`";
		$res = $id
			? $db->createCommand($sql)->queryRow()
			: $db->createCommand($sql)->queryAll();
		return $res;
	}
	
	public static function getDropDownListData($what, $parent_id = null)
	{
		$res = self::getData($what, $parent_id);
		$data = array();
		foreach($res as $r)
			$data[$r['key']] = $r['value'];
		
		return $data;
	}
	
	public static function getSingleValue($what, $id)
	{
		if(!$id)
			return null;
		$data = self::getData($what, 0, $id);
		return $data? $data['value'] : null;
	}
}

?>
