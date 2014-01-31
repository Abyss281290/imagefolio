<?php

/**
 * This is the model class for table "agency_models_packages_items".
 *
 * The followings are the available columns in table 'agency_models_packages_items':
 * @property integer $package_id
 * @property string $item_type
 * @property integer $item_id
 *
 * The followings are the available model relations:
 * @property AgencyModelsPackages $package
 */
class ModelsPackagesItems extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ModelsPackagesItems the static model class
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
		return 'agency_models_packages_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('package_id, item_type, item_id', 'required'),
			array('package_id, item_id', 'numerical', 'integerOnly'=>true),
			array('item_type', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('package_id, item_type, item_id', 'safe', 'on'=>'search'),
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
			'package' => array(self::BELONGS_TO, 'ModelsPackages', 'package_id'),
			'model' => array(self::BELONGS_TO, 'Models', 'model_id'),
			'image' => array(self::BELONGS_TO, 'GalleryImage', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'package_id' => 'Package',
			'item_type' => 'Item Type',
			'item_id' => 'Item',
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

		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('item_type',$this->item_type,true);
		$criteria->compare('item_id',$this->item_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}