<?php

class AgenciesUrlRule extends CBaseUrlRule
{
	public function createUrl($manager,$route,$params,$ampersand)
	{
		if ($route == 'agency/agencies/default/register')
		{
			return 'register';
		}
		elseif ($route == 'agency/agencies/default/view')
		{
			if(isset($params['id'])) {
				if($model = Agencies::model()->findByPk($params['id'])) {
					return $model->short_name;
				}
			}
		}
		elseif($route == 'agency/models/requests/create')
		{
			if(isset($params['agency_id'])) {
				if($model = Agencies::model()->findByPk($params['agency_id'])) {
					return $model->short_name.'/become_a_model';
				}
			}
		}
		elseif($route == 'agency/models/default/index')
		{
			if(isset($params['agency_id'], $params['type_id'])) {
				if(
					($agency = Agencies::model()->findByPk($params['agency_id']))
					&& ($type = AgencyTypes::model()->findByPk($params['type_id']))
				) {
					return $agency->short_name.'/models/'.$type->url;
				}
			}
		}
		elseif(preg_match('#^agency/agencies/default/(\w+)#',$route,$matches) && $route != 'agency/agencies/default/confirm')
		{
			if(isset($params['agency_id'])) {
				if($model = Agencies::model()->findByPk($params['agency_id'])) {
					return $model->short_name.'/'.$matches[1];
				}
			}
		}
		elseif($route == 'agency/models/default/view')
		{
			if($model = Models::model()->findByPk($params['id'])) {
				return $model->agency->short_name.'/models/'.$model->type->url.'/'.$model->url;
			}
		}
		return false;
	}

	public function parseUrl($manager,$request,$pathInfo,$rawPathInfo)
	{
		Yii::app()->getModule('agency');
		if($pathInfo == 'register')
		{
			return 'agency/agencies/default/register';
		}
		elseif($model = Agencies::model()->findByAttributes(array('short_name'=>$pathInfo)))
		{
			return 'agency/agencies/default/view/id/'.$model->id;
		}
		elseif(preg_match('#([^/]+)/become_a_model#', $pathInfo, $matches))
		{
			$model = Agencies::model()->findByAttributes(array('short_name'=>$matches[1]));
			return 'agency/models/requests/create/agency_id/'.$model->id;
		}
		// model view page
		elseif(preg_match('#([^/]+)/models/([^/]+)/([^/]+)#', $pathInfo, $matches))
		{
			$model = Models::model()->findByAttributes(array('url'=>$matches[3]));
			if($model && $model->agency->short_name == $matches[1] && $model->type->url == $matches[2])
				return 'agency/models/default/view/id/'.$model->id;
		}
		// models index page
		elseif(preg_match('#([^/]+)/models/([^/]+)#', $pathInfo, $matches))
		{
			$agency = Agencies::model()->findByAttributes(array('short_name'=>$matches[1]));
			$type = AgencyTypes::model()->findByAttributes(array('url'=>$matches[2]));
			if($agency && $type)
				return 'agency/models/default/index/agency_id/'.$agency->id.'/type_id/'.$type->id;
		}
		elseif(preg_match('#([^/]+)/(\w+)#', $pathInfo, $matches))
		{
			$model = Agencies::model()->findByAttributes(array('short_name'=>$matches[1]));
			if($model)
				return 'agency/agencies/default/'.$matches[2].'/agency_id/'.$model->id;
		}
		return false;
	}
}