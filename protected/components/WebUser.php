<?php
class WebUser extends CWebUser {
	
		public $loginUrl = array('site/login');
		private $_model = null;
		public $amount;
		public $event_count;
 
	public function getRole() {
		return $this->isGuest ? NULL : $this->role ;
	}

	public function isAdmin()
	{
		return $this->getRole() == 'admin';
	}
	
	public function isAdminAsAgency()
	{
		return $this->hasState('admin_id') && !!$this->admin_id;
	}
	
	public function isAgency()
	{
		return $this->getRole() == 'agency';
	}

	public function isBooker()
	{
		return $this->getRole() == 'booker';
	}
	
	public function isAgencyMember()
	{
		return $this->isAgency() || $this->isBooker();
	}
	
	public function getFlashes($delete=true)
	{
		$flashes=(array)$_SESSION[self::FLASH_KEY_PREFIX];
		if($delete) {
			unset($_SESSION[self::FLASH_KEY_PREFIX]);
			$this->setState(self::FLASH_COUNTERS,array());
		}
		return $flashes;
	}
	
	public function getFlash($key,$defaultValue=null,$delete=true,$type='default')
	{
		$value = isset($_SESSION[self::FLASH_KEY_PREFIX][$type][$key])
			? $_SESSION[self::FLASH_KEY_PREFIX][$type][$key]
			: $defaultValue;
		if($delete)
			$this->setFlash($key,null,$defaultValue,$type);
		return $value;
	}
	
	public function setFlash($key,$value,$defaultValue=null,$type='default')
	{
		$_SESSION[self::FLASH_KEY_PREFIX][$type][$key] = $value;
		$counters=$this->getState(self::FLASH_COUNTERS,array());
		if($value===$defaultValue)
			unset($counters[$key]);
		else
			$counters[$key]=0;
		$this->setState(self::FLASH_COUNTERS,$counters,array());
	}
	
	public function hasFlash($key,$type='default')
	{
		return $this->getFlash($key, null, false, $type)!==null;
	}
	
	public function addFlashInfo($key,$value,$defaultValue=null)
	{
		$this->setFlash($key,$value,$defaultValue,'info');
	}
	
	public function addFlashError($key,$value,$defaultValue=null)
	{
		$this->setFlash($key,$value,$defaultValue,'error');
	}
	
	public function addFlashWarning($key,$value,$defaultValue=null)
	{
		$this->setFlash($key,$value,$defaultValue,'warning');
	}
	
	public function addFlashSuccess($key,$value,$defaultValue=null)
	{
		$this->setFlash($key,$value,$defaultValue,'success');
	}
}