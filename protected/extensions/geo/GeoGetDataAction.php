<?php
class GeoGetDataAction extends CAction
{
	public function run()
	{
		Yii::import('ext.geo.GeoHelper');
		echo CJSON::encode(GeoHelper::getDropDownListData($_REQUEST['what'], $_REQUEST['parent_id']));
		die();
	}
}