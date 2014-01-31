<?php

/**
 * This is the model class for table "agency_plans".
 *
 * The followings are the available columns in table 'agency_plans':
 * @property integer $id
 * @property string $title
 * @property integer $models_allowed
 * @property integer $price
 * @property integer $additional_model_price
 * @property integer $images_allowed
 */
class AgencyPlans extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AgencyPlans the static model class
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
		return 'agency_plans';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, models_allowed, price, images_allowed', 'required'),
			array('models_allowed, price, images_allowed, website, packages, submissions', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, models_allowed, price, images_allowed', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Option',
			'models_allowed' => 'Talents',
			'price' => '$ Month',
			'additional_model_price' => 'Charge per extra Talent on system per month',
			'images_allowed' => 'Images',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('models_allowed',$this->models_allowed);
		$criteria->compare('price',$this->price);
		$criteria->compare('images_allowed',$this->images_allowed);
		$criteria->compare('website',$this->website);
		$criteria->compare('packages',$this->packages);
		$criteria->compare('submissions',$this->submissions);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}