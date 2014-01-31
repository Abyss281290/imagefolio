<?php

/**
 * This is the model class for table "models_requests".
 *
 * The followings are the available columns in table 'models_requests':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $type_id
 * @property integer $type2_id
 * @property string $type_values
 * @property string $type2_values
 * @property string $birthday
 * @property string $telephone
 * @property string $telephone2
 * @property string $address
 * @property string $about
 */
class ModelsRequests extends CActiveRecord
{
		public $verifyCode;
		public $letter;
		
		public $imageAttributes = array('image_head_shot','image_mid_length','image_full_length');
	/**
	 * Returns the static model of the specified AR class.
	 * @return ModelsRequests the static model class
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
		return 'models_requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('agency_id, name, email, type_id, birthday, telephone, telephone2, address, about', 'required'),
			array('agency_id, name, email', 'required'),
			array('email', 'email'),
			array('type_id, birthday, telephone, telephone2, address, about, type_values, type2_values, image_head_shot, image_mid_length, image_full_length, created_time', 'safe'),
			//array('type_values, type2_values', 'characteristicsValidation'),
			//array('verifyCode', 'required'),
			array('type_id, type2_id', 'numerical', 'integerOnly'=>true),
			array('name, email, telephone, telephone2', 'length', 'max'=>255),
			//array('image_head_shot','file','types'=>'jpeg, jpg, png, gif','maxFiles'=>1,'maxSize'=>2*1024*1024,'allowEmpty'=>$this->scenario!='insert'),
			//array('image_mid_length','file','types'=>'jpeg, jpg, png, gif','maxFiles'=>1,'maxSize'=>2*1024*1024,'allowEmpty'=>$this->scenario!='insert'),
			//array('image_full_length','file','types'=>'jpeg, jpg, png, gif','maxFiles'=>1,'maxSize'=>2*1024*1024,'allowEmpty'=>$this->scenario!='insert'),
			array('verifyCode', 'captcha', 'allowEmpty'=>(Yii::app()->controller->isAdmin() || !CCaptcha::checkRequirements())),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, type_id, type2_id, type_values, type2_values, birthday, telephone, telephone2, address, about, letter', 'safe', 'on'=>'search'),
		);
	}
	
	public function characteristicsValidation($attribute,$params)
	{
		CharacteristicsHelper::characteristicsValidation($this,$attribute,$params);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'agency' => array(self::BELONGS_TO, 'Agencies', 'agency_id'),
			'type' => array(self::BELONGS_TO, 'AgencyTypes', 'type_id'),
			'type2' => array(self::BELONGS_TO, 'AgencyTypes', 'type2_id'),
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
			'agency_id' => 'Agency',
			'name' => 'Name',
			'email' => 'Email',
			'type_id' => 'Type',
			'type2_id' => 'Type2',
			'birthday' => 'Birthday',
			'telephone' => 'Home Phone Number',
			'telephone2' => 'Cell Number',
			'address' => 'Address',
			'about' => 'About',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('telephone2',$this->telephone2,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('about',$this->about,true);
		
		if($this->letter)
			$criteria->compare("SUBSTRING(name,1,1)", $this->letter);
		if($this->type_id)
			$criteria->addColumnCondition(array('type_id'=>$this->type_id, 'type2_id'=>$this->type_id), 'OR');
		
		if(Yii::app()->user->isAgency())
			$criteria->compare('agency_id',Yii::app()->user->agency_id);
		elseif(Yii::app()->user->isBooker())
			$criteria->compare('agency_id',Yii::app()->user->agency_id);
		elseif(isset($_REQUEST['agency_id'])) {
			$criteria->compare('agency_id',$_REQUEST['agency_id']);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC'
			)
		));
	}
	
	public function afterValidate()
	{
		if($this->scenario == 'insert' && !$this->image_head_shot && !$this->image_mid_length && !$this->image_full_length) {
			$this->addError(null, 'You must upload at least one image');
		}
		
		parent::afterValidate();
	}
	
	protected function beforeSave()
	{
		if(Yii::app()->controller->isAdmin() && !Yii::app()->user->isAdmin())
			$this->agency_id = Yii::app()->user->agency_id;
		
		if($this->scenario == 'insert') {
			$this->created_time = new CDbExpression('NOW()');
		}
		
		$this->type_values = is_array($this->type_values)? serialize($this->type_values) : '';
		$this->type2_values = is_array($this->type2_values)? serialize($this->type2_values) : '';
		
		$module = Yii::app()->getModule('agency')->getModule('models');
		$mediaPath = $module->requestsImagesPath.'/'.$this->agency_id;
		$tmpPath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$module->tmpPath;
		$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$module->requestsImagesPath;
		Yii::app()->image->createImagesDirectory($filename_path);
		$filename_path .= DIRECTORY_SEPARATOR.$this->agency_id;
		Yii::app()->image->createImagesDirectory($filename_path);
		$resize = $module->requestsImagesThumbsSize;
		
		foreach($this->imageAttributes as $attribute)
		{
			if(!$this->$attribute)
				continue;
			if($this->scenario == 'insert')
			{
				$filename = time().'_'.$attribute.substr($this->$attribute, strrpos($this->$attribute, '.'));
				$old_image = @self::model()->findByPk($this->id)->$attribute;
				if(!empty($old_image)) { // delete old files
					$this->removeMedia($mediaPath, 'thumb_'.$old_image->source);
					$this->removeMedia($mediaPath, $old_image->source);
				}
				copy($tmpPath.'/'.$this->$attribute, $filename_path . DIRECTORY_SEPARATOR . $filename);
				copy($tmpPath.'/'.$this->$attribute, $filename_path . DIRECTORY_SEPARATOR . 'thumb_'.$filename);
				if($resize) {
					$img = Yii::app()->image->load($filename_path.DIRECTORY_SEPARATOR.'thumb_'.$filename);
					$img->resize($resize['width'], $resize['height'], constant('Image::'.strtoupper($resize['master'])));
					$img->quality($resize['quality']);
					$img->save();
				}
				unlink($tmpPath.'/'.$this->$attribute);
				unlink($tmpPath.'/thumb_'.$this->$attribute);
				$this->$attribute = $filename;
			}
			else
			{
				$this->$attribute = $this->$attribute->source;
			}
			/*unset($this->$attribute);
			if($filename_new = CUploadedFile::getInstance($this, $attribute))
			{
				$filename = time().'_'.$attribute.'.'.$filename_new->getExtensionName();
				$old_image = @self::model()->findByPk($this->id)->$attribute;
				if(!empty($old_image)) { // delete old files
					$this->removeMedia($mediaPath, 'thumb_'.$old_image->source);
					$this->removeMedia($mediaPath, $old_image->source);
				}
				if(!$filename_new->saveAs($filename_path . DIRECTORY_SEPARATOR . $filename, false)) {
					//throw new CHttpException(400, 'File not saved');
				} else {
					$filename_new->saveAs($filename_path . DIRECTORY_SEPARATOR . 'thumb_'.$filename);
					if($resize) {
						$img = Yii::app()->image->load($filename_path.DIRECTORY_SEPARATOR.'thumb_'.$filename);
						$img->resize($resize['width'], $resize['height']);
						$img->quality($resize['quality']);
						$img->save();
					}
					$this->$attribute = $filename;
				}
			}*/
		}
		
		return parent::beforeSave();
	}
	
	public function afterConstruct()
	{
		if(Yii::app()->controller->isAdmin() && !Yii::app()->user->isAdmin()) {
			$this->agency_id = Yii::app()->user->agency_id;
			$this->agency = Agencies::model()->findByPk($this->agency_id);
		}
	}
	
	public function afterFind()
	{
		$this->type_values = @unserialize($this->type_values);
		if(!$this->type_values)
			$this->type_values = array();
		$this->type2_values = @unserialize($this->type2_values);
		if(!$this->type2_values)
			$this->type2_values = array();
		
		// image
		$m = Yii::app()->getModule('agency')->getModule('models');
		
		$currentGalleryPath = Yii::app()->baseUrl.'/'.$m->requestsImagesPath.'/'.$this->agency_id;
		$currentSysGalleryPath = Yii::getPathOfAlias('webroot').'/'.$m->requestsImagesPath.'/'.$this->agency_id;
		foreach($this->imageAttributes as $attribute) {
			if(is_file($currentSysGalleryPath.'/'.$this->$attribute)) {
				$this->$attribute = (object)array(
					'source' => $this->$attribute,
					'thumb' => $currentGalleryPath.'/thumb_'.$this->$attribute,
					'full' => $currentGalleryPath.'/'.$this->$attribute,
					'exists' => true
				);
			} else {
				$this->$attribute = null;
				/*
				$path = $m->assetPath.'/images/noimage.png';
				$this->$attribute = (object)array(
					'source' => 'noimage.png',
					'thumb' => $path,
					'full' => $path,
					'exists' => false
				);
				*/
			}
		}
		
		parent::afterFind();
	}
	
	public function afterDelete()
	{
		$m = Yii::app()->getModule('agency')->getModule('models');
		foreach($this->imageAttributes as $attribute) {
			$this->removeMedia($m->requestsImagesPath.'/'.$this->agency_id, $this->$attribute->source);
			$this->removeMedia($m->requestsImagesPath.'/'.$this->agency_id, 'thumb_'.$this->$attribute->source);
		}
		
		parent::afterDelete();
	}
	
	public function removeMedia($mediaPath, $objectSrc)
	{
		$mediaPath = str_replace('/', DIRECTORY_SEPARATOR, $mediaPath);
		$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$mediaPath;
		if(is_file( $path = $filename_path . DIRECTORY_SEPARATOR . $objectSrc ))
			return @unlink($path);
		return false;
	}
}