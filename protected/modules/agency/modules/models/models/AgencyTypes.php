<?php

/**
 * This is the model class for table "agency_types".
 *
 * The followings are the available columns in table 'agency_types':
 * @property integer $id
 * @property string $name
 */
class AgencyTypes extends CActiveRecord
{
		public $display_title;
	/**
	 * Returns the static model of the specified AR class.
	 * @return AgencyTypes the static model class
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
		return 'agency_types';
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
			array('title, url', 'length', 'max'=>255),
			array('url, description, characteristics', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, url, description', 'safe', 'on'=>'search'),
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
			'characteristics'=>array(self::MANY_MANY, 'AgencyCharacteristics',
				'agency_types_characteristics_xref(type_id, characteristic_id)', 'on'=>'active=1')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'url' => 'Url Tag',
			'characteristics' => 'Related Characteristics',
		);
	}
	
	public function defaultScope()
	{
		return array(
			'order'=>'`order` ASC'
		);
	}
	
	public function beforeValidate()
	{
		Yii::import('ext.UrlTransliterate');
		$this->url = UrlTransliterate::cleanString($this->url);
		
		return parent::beforeValidate();
	}
	
	public function beforeSave()
	{
		if($this->url === '')
			$this->url = UrlTransliterate::cleanString($this->title);
		
		return parent::beforeSave();
	}
	
	public function afterSave()
	{
		if($this->scenario != 'order') {
			$db =& Yii::app()->db;
			$db->createCommand("DELETE FROM {{agency_types_characteristics_xref}} WHERE type_id=:type_id")
				->bindParam('type_id', $this->id)
				->execute();

			$q = $db->createCommand("INSERT INTO {{agency_types_characteristics_xref}}(type_id, characteristic_id) VALUES (:type_id, :characteristic_id)");
			$cids = array();
			foreach($this->characteristics as $cid) {
				$q->bindParam('type_id', $this->id);
				$q->bindParam('characteristic_id', $cid);
				$q->execute();
				$cids[] = $cid;
			}
			// remove models charachteristics if they not in our type
			//$db->createCommand("DELETE FROM {{models_characteristics_values}} WHERE characteristic_id NOT IN(".implode(',',$cids).")")
			//	->execute();
		}
		
		parent::afterSave();
	}
	
	public function afterFind()
	{
		$this->display_title = $this->description === ''? $this->title : $this->description;
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'`order` ASC',
			),
			'pagination'=>false
		));
	}
}