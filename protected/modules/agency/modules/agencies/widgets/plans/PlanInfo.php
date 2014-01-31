<?php

class PlanInfo extends CWidget
{
		public $agency_id = null;
	
	public function init()
	{
		if(!$this->agency_id) {
			$this->agency_id = AgencyModule::getCurrentAgencyId();
		}
		$agency = Agencies::model()->findByPk($this->agency_id);
		if(!$agency)
			return;
		$this->render('index',array(
			'agency'=>$agency
		));
	}
}