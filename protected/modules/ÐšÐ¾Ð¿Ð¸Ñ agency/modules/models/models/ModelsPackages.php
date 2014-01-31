<?php

/**
 * This is the model class for table "agency_models_packages".
 *
 * The followings are the available columns in table 'agency_models_packages':
 * @property integer $id
 * @property string $title
 * @property string $updated_time
 *
 * The followings are the available model relations:
 * @property AgencyModelsPackagesItems $agencyModelsPackagesItems
 */
class ModelsPackages extends CActiveRecord
{
		public $agency;
	/**
	 * Returns the static model of the specified AR class.
	 * @return ModelsPackages the static model class
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
		return 'agency_models_packages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>255),
			array('hash', 'unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, updated_time', 'safe', 'on'=>'search'),
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
			'items' => array(self::HAS_MANY, 'ModelsPackagesItems', 'package_id'),
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
			'title' => 'Title',
			'updated_time' => 'Updated Time',
		);
	}
	
	public function afterFind()
	{
		if($this->agency_id)
			$this->agency = Agencies::model()->findByPk($this->agency_id);
		if($this->booker_id)
			$this->agency = Agencies::model()->findByPk(AgencyBookers::model()->findByPk($this->booker_id)->agency_id);
		
		parent::afterFind();
	}
	
	public function beforeSave()
	{
		$this->updated_time = new CDbExpression('NOW()');
		
		if($this->isNewRecord || !$this->hash) {
			$this->hash = md5(uniqid(Yii::app()->user->id.time()));
		}
		
		return parent::beforeSave();
	}
	
	public function getModels()
	{
		$items = array();
		if($this->items) {
			foreach($this->items as $item) {
				if(!isset($items[$item->model_id])) {
					if($item->model)
						$items[$item->model_id] = $item->model;
				}
			}
		}
		return $items;
	}
	
	public function getImagesItems($model_id)
	{
		Yii::app()->getModule('gallery');
		$images = array();
		foreach($this->items as $item) {
			if($item->model_id == $model_id && $item->item_type == 'image')
				$images[] = $item;
		}
		/*if(!$images) {
			$gallery = Gallery::model()->findByAttributes(array(
				'scope'=>'models',
				'item_id'=>$model_id
			));
			if($gallery)
				$images = $gallery->images;
		}*/
		return $images;
	}
	
	public function getItems($item_type = '')
	{
		$items = array();
		if($this->items) {
			foreach($this->items as $item)
				$items[$item->item_type][] = $item;
		}
		return $item_type
			? (isset($items[$item_type])? $items[$item_type] : null)
			: $items;
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
		$criteria->compare('updated_time',$this->updated_time,true);
		
		if(Yii::app()->user->isAgency())
			$criteria->compare('agency_id',Yii::app()->user->agency_id);
		elseif(Yii::app()->user->isBooker())
			$criteria->compare('booker_id',Yii::app()->user->booker_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}