<?php

class CompaniesHelper
{
	public static function getDropDownListData()
	{
		$c = new CDbCriteria();
		$c->order = 'name';
		if(Yii::app()->user->isAgency())
			$c->addColumnCondition(array('agency_id'=>Yii::app()->user->agency_id));
		elseif(Yii::app()->user->isBooker())
			$c->addColumnCondition(array('booker_id'=>Yii::app()->user->booker_id));
		return CHtml::listData(AgencyCompanies::model()->findAll($c),'id','name');
	}
	
	public static function getListDataForMailing($char = '')
	{
		$c = new CDbCriteria();
		$c->order = 'name';
		if(Yii::app()->user->isAgency())
			$c->addColumnCondition(array('agency_id'=>Yii::app()->user->agency_id));
		elseif(Yii::app()->user->isBooker())
			$c->addColumnCondition(array('booker_id'=>Yii::app()->user->booker_id));
		if($char !== '')
			$c->addCondition('SUBSTRING(name,1,1) = '.Yii::app()->db->quoteValue($char));
		$data = array();
		if($items = AgencyCompanies::model()->findAll($c)) {
			foreach($items as $item) {
				$data[$item->id] = $item['name'].' <'.$item['email'].'>';
			}
		}
		return $data;
	}
	
	public function getDistinctNameFirstChars()
	{
			static $chars;
		if(!isset($chars))
		{
			if(Yii::app()->user->isAgency())
				$where = "agency_id = ".intval(Yii::app()->user->agency_id);
			elseif(Yii::app()->user->isBooker())
				$where = "booker_id = ".intval(Yii::app()->user->booker_id);
			$res = Yii::app()->db->createCommand("
				SELECT
					DISTINCT LOWER(SUBSTRING(name, 1, 1)) s
				FROM
					{{agency_companies}}
				WHERE {$where}
				ORDER BY s
			")->queryColumn();
			$chars = array();
			foreach($res as $c)
				$chars[$c] = strtoupper ($c);
		}
		return $chars;
	}
	
	public static function getContactsListDataForMailing($char = '')
	{
		$c = new CDbCriteria();
		$c->order = 't.name';
		$c->with = 'company';
		if(Yii::app()->user->isAgency())
			$c->addColumnCondition(array('company.agency_id'=>Yii::app()->user->agency_id));
		elseif(Yii::app()->user->isBooker())
			$c->addColumnCondition(array('company.booker_id'=>Yii::app()->user->booker_id));
		if($char !== '')
			$c->addCondition('SUBSTRING(t.name,1,1) = '.Yii::app()->db->quoteValue($char));
		$data = array();
		if($items = AgencyCompaniesContacts::model()->findAll($c)) {
			foreach($items as $item) {
				$data[$item->id] = $item['name'].' <'.$item['email'].'>';
			}
		}
		return $data;
	}
	
	public function getContactsDistinctNameFirstChars()
	{
			static $chars;
		if(!isset($chars))
		{
			if(Yii::app()->user->isAgency())
				$where = "ac.agency_id = ".intval(Yii::app()->user->agency_id);
			elseif(Yii::app()->user->isBooker())
				$where = "ac.booker_id = ".intval(Yii::app()->user->booker_id);
			$res = Yii::app()->db->createCommand("
				SELECT
					DISTINCT LOWER(SUBSTRING(acc.name, 1, 1)) s
				FROM
					{{agency_companies_contacts}} acc
				INNER JOIN {{agency_companies}} ac
				WHERE
					acc.company_id = ac.id
					AND {$where}
				ORDER BY s
			")->queryColumn();
			$chars = array();
			foreach($res as $c)
				$chars[$c] = strtoupper ($c);
		}
		return $chars;
	}
}

?>