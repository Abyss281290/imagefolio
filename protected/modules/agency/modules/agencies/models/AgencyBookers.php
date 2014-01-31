<?php

/**
 * This is the model class for table "agency_bookers".
 *
 * The followings are the available columns in table 'agency_bookers':
 * @property integer $id
 * @property integer $agency_id
 * @property string $email
 * @property string $password
 * @property integer $fullname
 * @property string $telephone
 * @property string $address
 *
 * The followings are the available model relations:
 * @property Agencies $agency
 */
class AgencyBookers extends CActiveRecord
{
		public $password2;
		public $initialPassword;
	/**
	 * Returns the static model of the specified AR class.
	 * @return AgencyBookers the static model class
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
		return 'agency_bookers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('agency_id, email, fullname', 'required'),
			array('email', 'email'),
			array('agency_id', 'numerical', 'integerOnly'=>true),
			array('email, password, telephone', 'length', 'max'=>255),
			array('address','safe'),
			array('password', 'required', 'on' => 'insert'),
			array('password', 'length', 'min'=>5, 'allowEmpty'=>true),
			array('password2', 'compare', 'compareAttribute' => 'password'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, agency_id, email, password, fullname, telephone, address', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'agency' => array(self::BELONGS_TO, 'Agencies', 'agency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'agency_id' => 'Agency',
			'email' => 'Email',
			'password' => 'Password',
			'password2' => 'Confirm Password',
			'fullname' => 'Fullname',
			'telephone' => 'Telephone',
			'address' => 'Address',
		);
	}
	
	public function afterFind()
	{
		//reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->password;
        $this->password = '';
		
		parent::afterFind();
	}
	
	public function beforeSave()
	{
		// in this case, we will use the old hashed password.
		if(empty($this->password) && empty($this->password2) && !empty($this->initialPassword))
			$this->password = $this->password2 = $this->initialPassword;
		/**
		 * @TODO: hash password before save
		 */
		
		if(!Yii::app()->user->isAdmin())
			$this->agency_id = Yii::app()->user->agency_id;
		
		return parent::beforeSave();
	}
	
	public function afterConstruct()
	{
		if(!Yii::app()->user->isAdmin()) {
			$this->agency_id = Yii::app()->user->agency_id;
			$this->agency = Agencies::model()->findByPk($this->agency_id);
		}
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('address',$this->address,true);
		
		if(!Yii::app()->user->isAdmin())
			$criteria->compare('agency_id',Yii::app()->user->agency_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}