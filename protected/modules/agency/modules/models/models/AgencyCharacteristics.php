<?php

/**
 * This is the model class for table "agency_characteristics".
 *
 * The followings are the available columns in table 'agency_characteristics':
 * @property integer $id
 * @property string $type
 * @property string $title
 */
class AgencyCharacteristics extends CActiveRecord
{	
	/**
	 * Returns the static model of the specified AR class.
	 * @return AgencyCharacteristics the static model class
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
		return 'agency_characteristics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, title', 'required'),
			array('type, title', 'length', 'max'=>255),
			array('description, data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, title', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'title' => 'Title',
		);
	}
	
	public function afterFind()
	{
		$this->data = @unserialize($this->data);
		$this->data = is_array($this->data)? $this->data : array();
		
		parent::afterFind();
	}
	
	public function beforeSave()
	{
		if(is_array($this->data)) {
			$tmp = $this->data;
			foreach($this->data as $k=>$data)
				$tmp[$k]['title'] = $data['value'];
			$this->data = $tmp;
			$this->data = @serialize(array_filter($this->data));
		}
		
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'`order` ASC',
			),
			'pagination'=>false
		));
	}
	
	public function renderElementLabel($model, $attributeWithValues)
	{
		CharacteristicsHelper::renderElementTypeLabel($this, $model, $attributeWithValues);
	}
	
	public function renderElement($model, $attributeWithValues)
	{
		CharacteristicsHelper::renderElementType($this, $model, $attributeWithValues);
	}
}