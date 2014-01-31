<?php

/**
 * This is the model class for table "agency_models_packages_reports".
 *
 * The followings are the available columns in table 'agency_models_packages_reports':
 * @property integer $id
 * @property integer $package_id
 * @property string $sender_role
 * @property integer $sender_user_id
 * @property string $recipient_name
 * @property string $recipient_email
 *
 * The followings are the available model relations:
 * @property AgencyModelsPackages $package
 */
class ModelsPackagesSimpleReports extends ModelsPackagesReports
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('package_id, sender_role, sender_user_id, recipient_email', 'required'),
			array('package_id, sender_user_id', 'numerical', 'integerOnly'=>true),
			array('sender_role, recipient_name, recipient_email', 'length', 'max'=>255),
			array('recipient_name', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, package_id, sender_role, sender_user_id, recipient_name, recipient_email, package_views, sender_filter', 'safe', 'on'=>'search'),
		);
	}
	
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'package' => array(self::BELONGS_TO, 'ModelsPackages', 'package_id'),
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
		
		$criteria->with = 'package';
		
		$criteria->compare('id',$this->id);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('sender_role',$this->sender_role,true);
		$criteria->compare('sender_user_id',$this->sender_user_id);
		$criteria->compare('recipient_name',$this->recipient_name,true);
		$criteria->compare('recipient_email',$this->recipient_email,true);
		$criteria->compare('package.views',$this->package_views);
		if($this->sender_filter && count($sf=explode(':',$this->sender_filter))==2) {
			// sender filter must be given as 'role:user_id'
			$criteria->addColumnCondition(array(
				'sender_role'=>$sf[0],
				'sender_user_id'=>$sf[1]
			));
		}
		
		if(Yii::app()->user->isAgency())
		{
			$criteria->addColumnCondition(array('t.agency_id' => Yii::app()->user->agency_id));
		}
		elseif(Yii::app()->user->isBooker())
		{
			$criteria->addColumnCondition(array(
				'sender_role' => Yii::app()->user->role,
				'sender_user_id' => Yii::app()->user->id
			));
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'recipient_name',
					'recipient_email',
					'package.title',
					'package_views'=>array(
						'asc'=>'package.views ASC',
						'desc'=>'package.views DESC'
					),
					'package.last_viewed_time',
					'id'
				)
			),
		));
	}
}