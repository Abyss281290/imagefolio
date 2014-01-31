<?php

/**
 * This is the model class for table "agency_invoices".
 *
 * The followings are the available columns in table 'agency_invoices':
 * @property integer $id
 * @property integer $agency_id
 *
 * The followings are the available model relations:
 * @property Agencies $agency
 * @property AgencyInvoicesItems[] $agencyInvoicesItems
 */
class AgencyInvoices extends CActiveRecord
{
		const PAYMENT_TYPE_UNDEFINED = 0;
		const PAYMENT_TYPE_CREDITCARD = 1;
		const PAYMENT_TYPE_BANK = 2;
		
		public $filter_paid_time_from;
		public $filter_paid_time_to;
		public $filter_create_time_from;
		public $filter_create_time_to;
		
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AgencyInvoices the static model class
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
		return 'agency_invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$rules = array(
			array('agency_id', 'required'),
			array('agency_id', 'numerical', 'integerOnly'=>true),
			array('payment_type', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, agency_id, price, paid, payment_type, filter_paid_time_from, filter_paid_time_to, filter_create_time_from, filter_create_time_to, removed', 'safe', 'on'=>'search'),
		);
		
		if(Yii::app()->user->isAdmin()) {
			$rules[] = array('comments, removed', 'safe');
		}
		
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
			'agency' => array(self::BELONGS_TO, 'Agencies', 'agency_id'),
			'items' => array(self::HAS_MANY, 'AgencyInvoicesItems', 'invoice_id'),
			'price' => array(self::STAT, 'AgencyInvoicesItems', 'invoice_id', 'select'=>'SUM(price)')
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
			'agency_id' => 'Agency'
		);
	}
	
	// scope agency records
	public function agency($agency_id)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'agency_id='.(int)$agency_id
		));
		return $this;
	}
	
	public function scopes()
	{
		return array(
			'notpaid' => array(
				'condition'=>'paid = 0'
			)
		);
	}
	
	// scope not removed records
	public function active()
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'removed=0'
		));
		return $this;
	}
	
	public function getPaymentTypeLabels()
	{
		return array(
			self::PAYMENT_TYPE_UNDEFINED => 'Not set',
			self::PAYMENT_TYPE_CREDITCARD => 'Credit card',
			self::PAYMENT_TYPE_BANK => 'Bank'
		);
	}
	
	public function getPaymentTypeLabel()
	{
		$labels = $this->getPaymentTypeLabels();
		return isset($labels[$this->payment_type])? $labels[$this->payment_type] : '';
	}
	
	public function pay()
	{
		if($this->id) {
			$this->paid = 1;
			$this->paid_time = new CDbExpression('NOW()');
			$this->payment_type = AgencyInvoices::PAYMENT_TYPE_CREDITCARD;
			return $this->update(array('paid','paid_time','payment_type'));
		}
		return false;
	}
	
	static public function getTotal($agency_id = null, $onlyDebt = false)
	{
		$db = Yii::app()->db;
		$where = array('and');
		$where[] = 'aii.invoice_id = ai.id';
		if($agency_id !== null)
			$where[] = 'agency_id = '.$db->quoteValue($agency_id);
		if($onlyDebt)
			$where[] = 'paid=0';
		$where[] = 'removed=0';
		$c = $db->createCommand()
			->select('SUM(price)')
			->from(self::tableName().' ai')
			->join(AgencyInvoicesItems::tableName().' aii')
			->where($where);
		return (float)$c->queryScalar();
	}


    static public function getCount($agency_id = null, $onlyDebt = false)
    {
        $db = Yii::app()->db;
        $where = array('and');
        $where[] = 'aii.invoice_id = ai.id';
        if($agency_id !== null)
            $where[] = 'agency_id = '.$db->quoteValue($agency_id);
        if($onlyDebt)
            $where[] = 'paid=0';
        $where[] = 'removed=0';
        $c = $db->createCommand()
            ->select('COUNT(*)')
            ->from(self::tableName().' ai')
            ->join(AgencyInvoicesItems::tableName().' aii')
            ->where($where);
        return (float)$c->queryScalar();
    }
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		if(isset($_REQUEST['paid']) && $this->paid === null) {
			$this->paid = (int)$_REQUEST['paid'];
		}
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$user = Yii::app()->user;
		$criteria=new CDbCriteria;
		$criteria->with = array('items');
		
		$criteria->compare('t.id',$this->id);
		if($user->isAdmin()) {
			if($this->agency_id === null && isset($_REQUEST['agency_id']))
				$this->agency_id = (int)$_REQUEST['agency_id'];
			$criteria->compare('agency_id',$this->agency_id);
		} else {
			$criteria->compare('agency_id',$user->agency_id);
			$criteria->compare('removed', 0);
		}
		if($this->price <= 0)
			$this->price = '';
		//$criteria->compare('price',$this->price);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('payment_type',$this->payment_type);
		$criteria->compare('removed',$this->removed);
		//$criteria->compare('create_time',$this->create_time);
		$toMysql = function($str, $suffix){
			$d = explode('/',$str);
			if(count($d)==3)
				return implode('-', array($d[2],$d[0],$d[1])).' '.$suffix;
			return null;
		};
		$this->filter_create_time_from = $toMysql($this->filter_create_time_from, '00:00:00');
		$this->filter_create_time_to = $toMysql($this->filter_create_time_to, '23:59:59');
		if($this->filter_create_time_from && $this->filter_create_time_to) {
			$criteria->addBetweenCondition('create_time', $this->filter_create_time_from, $this->filter_create_time_to);
		} elseif($this->filter_create_time_from) {
			$criteria->compare('create_time', '>= '.$this->filter_create_time_from);
		} elseif($this->filter_create_time_to) {
			$criteria->compare('create_time', '<= '.$this->filter_create_time_to);
		}
		
		$this->filter_paid_time_from = $toMysql($this->filter_paid_time_from, '00:00:00');
		$this->filter_paid_time_to = $toMysql($this->filter_paid_time_to, '23:59:59');
		if($this->filter_paid_time_from && $this->filter_paid_time_to) {
			$criteria->addBetweenCondition('paid_time', $this->filter_paid_time_from, $this->filter_paid_time_to);
		} elseif($this->filter_paid_time_from) {
			$criteria->compare('paid_time', '>= '.$this->filter_paid_time_from);
		} elseif($this->filter_paid_time_to) {
			$criteria->compare('paid_time', '<= '.$this->filter_paid_time_to);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC'
			)
		));
	}
}