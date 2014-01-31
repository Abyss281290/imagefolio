<?php
class Agencies extends CActiveRecord
{
		public $layout = 'tile';
		public $owner_password2;
		
		public $initialPassword;
		
		public $verifyCode;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Agencies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'agencies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		//$purifier = new CHtmlPurifier();
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('short_name, full_name, telephone, owner_email, owner_login', 'required'),
			array('website, address, owner_name, country_code, about, terms, layout', 'required', 'on'=>'insert,update'),
			array('owner_email', 'email'),
			array('short_name, owner_login, owner_email', 'unique'),
			array('color_site, color_menu, confirmed, date_registered, home_text, contacts', 'safe'),
			array('short_name, full_name, telephone, website, owner_name, owner_email, owner_login, owner_password, country_code, city_id, google_analytics_account', 'length', 'max'=>255),
			array('owner_password', 'required', 'on' => 'insert,register'),
			array('owner_password', 'length', 'min'=>5, 'allowEmpty'=>true),
			array('owner_password2', 'compare', 'compareAttribute' => 'owner_password'),
			
			array('home_text, about, contacts, terms, google_analytics_account', 'filter', 'filter'=>array(&$this, 'purifyContent')),
			
			array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg, jpeg, gif, png', 'maxFiles' => 1),
			
			array('verifyCode', 'captcha', 'allowEmpty'=>!Yii::app()->user->isGuest || !CCaptcha::checkRequirements()),
			//array('banner', 'file', 'allowEmpty' => true, 'types' => 'jpg, jpeg, gif, png', 'maxFiles' => 1),
			//array('splash', 'file', 'allowEmpty' => true, 'types' => 'jpg, jpeg, gif, png, swf', 'maxFiles' => 1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, short_name, full_name, telephone, website, address, owner_name, owner_email, owner_password, country_code, city_id, about, terms, layout, confirmed', 'safe', 'on'=>'search'),
		);
	}
	
	public function purifyContent($string)
	{
		return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $string);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'users' => array(self::HAS_MANY, 'Users', 'agency_id'),
			'models_count' => array(self::STAT, 'Models', 'agency_id'),
			'menu' => array(self::HAS_MANY, 'AgencyMenus', 'agency_id'),
			'plan' => array(self::BELONGS_TO, 'AgencyPlans', 'plan_id'),
		);
	}
	
	public function behaviors()
	{
		return array('datetimeI18NBehavior' => array('class' => 'ext.DateTimeI18NBehavior'));
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'short_name' => 'Short Name',
			'full_name' => 'Full Name',
			'telephone' => 'Telephone',
			'website' => 'Website',
			'address' => 'Address',
			'owner_name' => 'Owner Name',
			'owner_email' => 'Agency Email',
			'owner_login' => 'Agency Login',
			'owner_password' => 'Agency Password',
			'owner_password2' => 'Confirm Agency Password',
			'country_code' => 'Country',
			'city_id' => 'City',
			'about' => 'About Agency',
			'terms' => 'Terms',
			'image' => 'Logo',
			'color_site' => 'Site color',
			'color_menu' => 'Menu color',
			'banner' => 'Banner',
			'splash' => 'Splash page',
			'plan' => 'Option',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('short_name',$this->short_name,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('owner_name',$this->owner_name,true);
		$criteria->compare('owner_email',$this->owner_email,true);
		$criteria->compare('owner_password',$this->owner_password,true);
		$criteria->compare('country_code',$this->country_code,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('confirmed',$this->confirmed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC'
			)
		));
	}
	
	public function removeMedia($mediaPath, $objectSrc)
	{
		//$m = Yii::app()->getModule('agency')->getModule('agencies');
		$objectSrc = $objectSrc;
		$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$mediaPath;
		if(is_file( $path = $filename_path . DIRECTORY_SEPARATOR . $objectSrc ))
			return @unlink($path);
		return false;
	}
	
	public function getConfirmationUrl()
	{
		return Yii::app()->createAbsoluteUrl('/agency/agencies/default/confirm',array(
			'agency_id'=>$this->id,
			'confirmation_key'=>$this->confirmation_key
		));
	}
	
	public function getFrontUrl()
	{
		return Yii::app()->createAbsoluteUrl('/agency/agencies/default/view', array('id'=>$this->id));
	}
	
	public function getAdminUrl()
	{
		return Yii::app()->createAbsoluteUrl('/agency/agencies/admin/update', array('id'=>$this->id));
	}
	
	public function isPaid($checkPlan = true, $checkInvoiceDateGap = true)
	{
		$condition = 'agency_id = :aid AND paid = 0';
		if($checkInvoiceDateGap)
			$condition .= ' AND create_time + INTERVAL 5 DAY <= NOW()';
		return
			// if no plan selected
			($checkPlan == true && $this->plan_id == 0)
			// ignore date gap if it is agencies first payment
			//|| ($this->payment_date == false || $this->payment_date == '0000-00-00')
			|| $this->confirmed == 0
			|| AgencyInvoices::model()->count($condition, array(':aid'=>$this->id))
		? false : true;
	}
	
	public function canAddModels()
	{
		return $this->models_count < $this->plan->models_allowed;
	}
	
	protected function afterFind()
	{
		//reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->owner_password;
        $this->owner_password = '';
		
		if($this->scenario == 'update')
		{
			// image
			$m = Yii::app()->getModule('agency')->getModule('agencies');

			$currentGalleryPath = Yii::app()->baseUrl.'/'.$m->logosPath;
			$currentSysGalleryPath = Yii::getPathOfAlias('webroot').'/'.$m->logosPath;
			if(is_file($currentSysGalleryPath.'/'.$this->image)) {
				$this->image = (object)array(
					'source' => $this->image,
					'full' => $currentGalleryPath.'/'.$this->image,
					'exists' => true
				);
			} else {
				$path = $m->assetPath.'/images/noimage.png';
				$this->image = (object)array(
					'source' => 'noimage.png',
					'full' => $path,
					'exists' => false
				);
			}

			// banner
			$currentGalleryPath = Yii::app()->baseUrl.'/'.$m->bannersPath;
			$currentSysGalleryPath = Yii::getPathOfAlias('webroot').'/'.$m->bannersPath;
			if(is_file($currentSysGalleryPath.'/'.$this->banner)) {
				$this->banner = (object)array(
					'source' => $this->banner,
					'full' => $currentGalleryPath.'/'.$this->banner,
					'exists' => true
				);
			} else {
				$path = $m->assetPath.'/images/noimage.png';
				$this->banner = (object)array(
					'source' => 'noimage.png',
					'full' => $path,
					'exists' => false
				);
			}

			// splash page
			$currentGalleryPath = Yii::app()->baseUrl.'/'.$m->splashesPath;
			$currentSysGalleryPath = Yii::getPathOfAlias('webroot').'/'.$m->splashesPath;
			if(is_file($path = $currentSysGalleryPath.'/'.$this->splash)) {
				$info = pathinfo($path);
				switch($info['extension'])
				{
					case 'swf':
						$type = 'flash';
						break;
					default:
						$type = 'image';
						break;
				}
				$this->splash = (object)array(
					'type' => $type,
					'source' => $this->splash,
					'full' => $currentGalleryPath.'/'.$this->splash,
					'exists' => true
				);
			} else {
				$path = $m->assetPath.'/images/noimage.png';
				$this->splash = (object)array(
					'type' => 'image',
					'source' => 'noimage.png',
					'full' => $path,
					'exists' => false
				);
			}

			// colors
			$this->color_site
				? $mixedAgency->color_site
				: current(AgenciesHelper::getThemeColors());
			$this->color_menu
				? $mixedAgency->color_menu
				: current(AgenciesHelper::getThemeColors());
		}
		
		parent::afterFind();
	}
	
	public function beforeValidate()
	{
		$this->short_name = UrlTransliterate::cleanString($this->short_name);
		
		return parent::beforeValidate();
	}
	
	protected function beforeSave()
	{
		//$this->short_name = UrlTransliterate::cleanString($this->short_name);
		if(in_array($this->scenario, array('insert','register')))
		{
			$this->confirmation_key = md5(uniqid($this->id));
			// if is admin then confirm agency automatically
			$this->confirmed = (int)Yii::app()->controller->isAdmin();
			$this->date_registered = new CDbExpression('NOW()');
		}
		// in this case, we will use the old hashed password.
		if(empty($this->owner_password) && empty($this->owner_password2) && !empty($this->initialPassword))
			$this->owner_password = $this->owner_password2 = $this->initialPassword;
		/**
		 * @TODO: hash password before save
		 */
		
		$module = Yii::app()->getModule('agency')->getModule('agencies');
		
		// process agency logo
		$attributes = array(
			'image' => array($module->logosPath, $module->logoResize),
			'banner' => array($module->bannersPath, $module->bannerResize),
			'splash' => array($module->splashesPath, false)
		);
		foreach($attributes as $attribute => $data)
		{
			list($mediaPath, $resize) = $data;
			unset($this->$attribute);

			if($filename_new = CUploadedFile::getInstance($this, $attribute))
			{
				$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$mediaPath;
				Yii::app()->image->createImagesDirectory($filename_path);
				$filename = time() . '_' . $filename_new->getName();
				$old_image = @self::model()->findByPk($this->id)->$attribute;
				if(!empty($old_image)) { // delete old files
					$this->removeMedia($mediaPath, $old_image->source);
				}
				if(!$filename_new->saveAs($filename_path . DIRECTORY_SEPARATOR . $filename)) {
					//throw new CHttpException(400, 'File not saved');
				} else {
					if($resize) {
						$img = Yii::app()->image->load($filename_path.DIRECTORY_SEPARATOR.$filename);
						$img->resize($resize['width'], $resize['height'], $resize['master']);
						$img->quality($resize['quality']);
						$img->save();
					}
					$this->$attribute = $filename;
				}
			}
		}
		
		return parent::beforeSave();
	}
	
	public function afterDelete()
	{
		parent::afterDelete();
		
		$module = Yii::app()->getModule('agency')->getModule('agencies');
		$attributes = array(
			'image' => $module->logosPath,
			'banner' => $module->bannersPath,
			'splash' => $module->splashesPath
		);
		foreach($attributes as $attribute => $mediaPath)
		{
			$this->removeMedia($mediaPath, $this->$attribute->source);
		}
	}
}