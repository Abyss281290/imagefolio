<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $passwd
 * @property string $salt
 * @property string $email
 * @property integer $agency_id
 * @property string $role
 */
class User extends CActiveRecord
{
		const USER_ENABLE = 0;
		public $password_repeat;
		public $initialPassword;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return 'users';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules = array(
			array('username, email, role', 'required'),
			array('username','unique'),
			//array('agency_id', 'numerical', 'integerOnly'=>true),
			array('email', 'email'),
			array('salt, password_repeat', 'safe'),
			array('username, email, role', 'length', 'max'=>255),
			array('salt', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, email, role', 'safe', 'on'=>'search'),
		);
		
		$rules[] = array('password', 'required', 'on' => 'insert');
		$rules[] = array('password', 'length', 'max'=>40, 'min'=>5, 'allowEmpty'=>true);
		$rules[] = array('password_repeat', 'compare', 'compareAttribute' => 'password');
		
		return $rules;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'password_repeat' => 'Confirm password',
			'salt' => 'Salt',
			'email' => 'Email',
			//'agency_id' => 'Agency',
			'role' => 'Role',
		);
	}
	
	protected function afterFind()
	{
		//reset the password to null because we don't want the hash to be shown.
		$this->initialPassword = $this->password;
		$this->password = '';
	}
	
	protected function beforeSave()
	{
		if(empty($this->password) && empty($this->password_repeat) && !empty($this->initialPassword))
			$this->password = $this->password_repeat = $this->initialPassword;
		else
			$this->password = $this->hashPassword($this->password);
		return parent::beforeSave();
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		//$criteria->compare('agency_id',$this->agency_id);
		$criteria->compare('role',$this->role,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function hashPassword($password)
	{
		return md5($password);
	}
	
	public function validatePassword($password)
    {
        return $this->hashPassword($password) == $this->initialPassword;
    }
}