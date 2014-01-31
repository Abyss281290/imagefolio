<?php

/**
 * This is the model class for table "agency_companies".
 *
 * The followings are the available columns in table 'agency_companies':
 * @property integer $id
 * @property integer $agency_id
 * @property string $name
 * @property string $category
 * @property string $email
 * @property string $address
 * @property string $telephone
 * @property string $comments
 *
 * The followings are the available model relations:
 * @property Agencies $agency
 */
class AgencyCompanies extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AgencyCompanies the static model class
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
		return 'agency_companies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category', 'required'),
			array('address, comments', 'safe'),
			//array('agency_id', 'numerical', 'integerOnly'=>true),
			array('name, email, telephone', 'length', 'max'=>255),
			array('email','email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, category, email, address, telephone, comments', 'safe', 'on'=>'search'),
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
			//'agency' => array(self::BELONGS_TO, 'Agencies', 'agency_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			//'agency_id' => 'Agency',
			'name' => 'Client',
			'category' => 'Category',
			'email' => 'Email',
			'address' => 'Address',
			'telephone' => 'Telephone',
			'comments' => 'Comments',
		);
	}
	
	public function afterConstruct()
	{
		/*if(!Yii::app()->user->isAdmin()) {
			$this->agency_id = Yii::app()->user->agency_id;
			$this->agency = Agencies::model()->findByPk($this->agency_id);
		}*/
	}
	
	public function beforeSave()
	{	
		if(Yii::app()->user->isAgency()) {
			$this->agency_id = Yii::app()->user->agency_id;
		} elseif(Yii::app()->user->isBooker()) {
			$this->booker_id = Yii::app()->user->booker_id;
			$this->agency_id = Yii::app()->user->agency_id;
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('comments',$this->comments,true);
		
		if(Yii::app()->user->isAgency())
			$criteria->compare('agency_id',Yii::app()->user->agency_id);
		elseif(Yii::app()->user->isBooker())
			$criteria->compare('booker_id',Yii::app()->user->booker_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}