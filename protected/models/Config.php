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
class Config extends CActiveRecord
{
		public $key;
		public $value;
	
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
		return Yii::app()->config->configTableName;
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules = array(
			array('key, value', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('key, value', 'safe', 'on'=>'search'),
		);
		
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
		return array();
	}
	
	public function afterFind()
	{
		$this->value = Yii::app()->config->get($this->key);
	}
	
	public function save($runValidation=true,$attributes=null)
	{
		if(!$runValidation || $this->validate($attributes)) {
			Yii::app()->config->set($this->key, $this->value);
			return true;
		}
		return false;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$c=new CDbCriteria;
		$c->compare('`key`',$this->key,true);
		//$criteria->compare('value',$this->value,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$c,
			'sort'=>array(
				'attributes'=>array(
					'key'=>array(
						'asc'=>'`key`',
						'desc'=>'`key` DESC'
					)
				)
			)
		));
	}
}