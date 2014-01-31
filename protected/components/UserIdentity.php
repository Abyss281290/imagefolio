<?php

class UserIdentity extends CUserIdentity
{
		private $_id;
		public $activate = false;
		public $type;

	public function __construct($type,$username,$password,$activate=false)
	{
		parent::__construct($username,$password);
		
		$this->type = $type;
		$this->activate = $activate;
	}

	public function authenticate()
	{
		Yii::app()->getModule('agency');
		switch($this->type)
		{
			case 'booker': {
				$record = AgencyBookers::model()->resetScope()->findByAttributes(array('email'=>$this->username));
				if(!$record) {
					// finally user not found
					$this->errorCode = self::ERROR_USERNAME_INVALID;
				} elseif($this->password != $record->initialPassword) {
					$this->errorCode = self::ERROR_PASSWORD_INVALID;
				} else {
					$this->errorCode = self::ERROR_NONE;
					$this->_id = $record->id;
					$this->setState('id', $record->id);
					$this->setState('username', $record->email);
					$this->setState('fullname', $record->fullname);
					$this->setState('role', 'booker');
					$this->setState('email', $record->email);
					$this->setState('booker_id', $record->id);
					$this->setState('agency_id', $record->agency_id);
				}
			} break;
			default:
			case 'agency':
			{
				$record = User::model()->resetScope()->find(
					'username = :username #AND status = '.User::USER_ENABLE,
					array(':username' => $this->username)
				);
				if(!$record)
				{
					// try to find user in agencies
					$record = Agencies::model()->resetScope()->findByAttributes(array(
						'owner_login'=>$this->username,
						'confirmed'=>1
					));
					if(!$record) {
						// finally user not found
						$this->errorCode = self::ERROR_USERNAME_INVALID;
					} elseif($this->password == $record->initialPassword) {
						$this->setAgencyStates($record);
					}
				}
				elseif(!$record->validatePassword($this->password))
				{
					$this->errorCode = self::ERROR_PASSWORD_INVALID;
				}
				else
				{
					$this->setAdminStates($record);
				}
			} break;
		}
		
		return !$this->errorCode;
	}
	
	public function setAdminStates($record)
	{
		$this->errorCode = self::ERROR_NONE;
		$this->_id = $record->id;
		$this->setState('id', $record->id);
		$this->setState('username', $record->username);
		$this->setState('fullname', $record->username);
		//$this->setState('role', $record->role);
		$this->setState('role', 'admin');
		$this->setState('email', $record->email);
		//$this->setState('agency_id', $record->agency_id);

		//if(empty($record->displayname)) {
		//	$this->setState('name', $record->username);
		//} else {
		//	$this->setState('name', $record->displayname);
		//}

		//if(is_null($record->avatar)) $record->avatar = '';
		//$this->setState('avatar', $record->avatar);
		//$this->setState('lang', $record->lang);
		//$this->setState('role', Lookup::item('UserRole', $record->role));
	}
	
	public function setAgencyStates($record)
	{
		$this->errorCode = self::ERROR_NONE;
		$this->_id = $record->id;
		$this->setState('id', $record->id);
		$this->setState('username', $record->owner_login);
		$this->setState('fullname', $record->owner_name);
		$this->setState('role', 'agency');
		$this->setState('email', $record->owner_email);
		$this->setState('agency_id', $record->id);
	}

	public function getId()
	{
		return $this->_id;
	}
}