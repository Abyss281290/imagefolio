<?php

/**
 * This is the model class for table "agency_invoices_items".
 *
 * The followings are the available columns in table 'agency_invoices_items':
 * @property integer $id
 * @property integer $invoice_id
 * @property double $price
 * @property string $title
 * @property string $description
 *
 * The followings are the available model relations:
 * @property AgencyInvoices $invoice
 */
class AgencyInvoicesItems extends CActiveRecord
{
		public $paid;
		public $paid_time;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AgencyInvoicesItems the static model class
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
		return 'agency_invoices_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_id, price, title, description', 'required'),
			array('invoice_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, invoice_id, price, title, description', 'safe', 'on'=>'search'),
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
			'invoice' => array(self::BELONGS_TO, 'AgencyInvoices', 'invoice_id'),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice_id' => 'Invoice',
			'price' => 'Price',
			'title' => 'Title',
			'description' => 'Description',
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
		
		$criteria->with = array('invoice');
		
		$criteria->compare('t.id',$this->id);
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('price',$this->price);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('invoice.paid',$this->paid);
		
		$criteria->addColumnCondition(array('invoice.agency_id'=>Yii::app()->user->agency_id));
		
		$criteria->order = 't.id ASC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>false,
			'pagination'=>false
		));
	}
	
	public function beforeSave()
	{
		/*if($this->paid) {
			$this->paid_time = new CDbExpression('NOW()');
		} else {
			$this->paid_time = null;
		}*/
		
		return parent::beforeSave();
	}
}