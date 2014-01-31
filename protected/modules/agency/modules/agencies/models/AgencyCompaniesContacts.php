<?php

/**
 * This is the model class for table "agency_companies_contacts".
 *
 * The followings are the available columns in table 'agency_companies_contacts':
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $email
 * @property string $telephone
 * @property string $telephone2
 * @property string $position
 * @property string $address
 * @property string $comments
 *
 * The followings are the available model relations:
 * @property AgencyCompanies $company
 */
class AgencyCompaniesContacts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AgencyCompaniesContacts the static model class
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
		return 'agency_companies_contacts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, name, email', 'required'),
			array('company_id', 'numerical', 'integerOnly'=>true),
			array('name, email, telephone, telephone2, position', 'length', 'max'=>255),
			array('address, comments', 'safe'),
			array('email','email'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_id, name, email, telephone, telephone2, position, address, comments', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'AgencyCompanies', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Client',
			'name' => 'Name',
			'email' => 'Direct Email',
			'telephone' => 'Direct Phone',
			'telephone2' => 'Cell Phone',
			'position' => 'Position',
			'address' => 'Address',
			'comments' => 'Comments',
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
		
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.email',$this->email,true);
		$criteria->compare('t.telephone',$this->telephone,true);
		$criteria->compare('t.telephone2',$this->telephone2,true);
		$criteria->compare('t.position',$this->position,true);
		$criteria->compare('t.address',$this->address,true);
		$criteria->compare('t.comments',$this->comments,true);
		
		if($this->company_id === null && isset($_REQUEST['company_id']))
			$this->company_id = $_REQUEST['company_id'];
		$criteria->compare('company_id',$this->company_id);
		
		$criteria->with = 'company';
		if(Yii::app()->user->isAgency())
			$criteria->compare('company.agency_id', Yii::app()->user->agency_id);
		elseif(Yii::app()->user->isBooker())
			$criteria->compare('company.booker_id',Yii::app()->user->booker_id);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}