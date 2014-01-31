<?php

class AgenciesUrlRule extends CBaseUrlRule
{
	public function createUrl($manager,$route,$params,$ampersand)
	{
		if ($route==='agency/agencies/default/view')
		{
			if(isset($params['id'])) {
				if($model = Agencies::model()->findByPk($params['id'])) {
					return $model->short_name;
				}
			}
		}
		return false;
	}

	public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
	{
		Yii::app()->getModule('agency');
		if($model = Agencies::model()->findByAttributes(array('short_name'=>$pathInfo)))
		{
			return 'agency/agencies/default/view/id/'.$model->id;
		}
		return false;
	}
}