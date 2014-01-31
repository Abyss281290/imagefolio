<?php
class AgencyModule extends CWebModule
{
		public $assetPath;
	
	public function init()
	{
		$this->setImport(array(
			$this->id.'.models.*',
			$this->id.'.helpers.*',
			$this->id.'.modules.models.models.*',
			$this->id.'.modules.models.helpers.*',
			$this->id.'.modules.agencies.models.*',
			$this->id.'.modules.agencies.helpers.*',
		));
		
		$this->setModules(array('agencies', 'models'));
		
		$this->assetPath = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets', false, -1, YII_DEBUG);
		
		//Yii::app()->urlManager->addRules(array(
		//	'agency/agencies/default/about/agency_id/1'=>'12'
		//), false);
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
	
	static public function getUser($role, $id = null)
	{
		switch($role)
		{
			case 'agency':
				if($id === null)
					$id = self::getCurrentAgencyId();
				return Agencies::model()->findByPk($id);
				break;
			case 'booker':
				return AgencyBookers::model()->findByPk($id);
				break;
			default:
				throw new CHttpException(400,'AgencyModule::getUser - Invalid role("'.$role.'") given');
				break;
		}
	}
	
	static public function getAgency($id = null)
	{
		return self::getUser('agency', $id);
	}
	
	static public function getBooker($id = null)
	{
		return self::getUser('booker', $id);
	}
	
	static public function getCurrentAgencyId()
	{
		$user = Yii::app()->user;
		if($user->isAgency() || $user->isBooker()) {
			return $user->agency_id;
		} else {
			throw new CHttpException(400,'AgencyModule::getCurrentAgencyId - User (#"'.$user->id.', '.$role.'") has no agency_id');
		}
	}
	
	static public function getUserFullName($role,$id)
	{
		if($user = self::getUser($role,$id)) {
			switch($role) {
				case 'agency':
					return $user->full_name;
				case 'booker':
					return $user->fullname;
			}
		}
		return null;
	}
	
	static public function isAgencyHasPlanOption($optionName, $agency_id = null)
	{
		$agency = self::getAgency($agency_id);
		if($agency && $agency->plan)
			return !!$agency->plan->$optionName;
		return false;
	}
	
	static public function getPaymentConfig()
	{
		return require dirname(__FILE__).'/config/payment.php';
	}
}
