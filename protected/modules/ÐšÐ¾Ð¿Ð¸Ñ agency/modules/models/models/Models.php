<?php
/**
 * This is the model class for table "content".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property integer $created_by
 * @property string $created_time
 * @property integer $active
 */
class Models extends CActiveRecord
{
		public $fullname;
		public $characteristics;
		//public $type;
		//public $type2;
		public $created_by_obj;
		public $updated_by_obj;
		
		// search
		public $letter;
		
	/**
	 * Returns the static model of the specified AR class.
	 * @return Content the static model class
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
		return 'models';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('type_id, firstname, lastname, email, birth_place, birthday, ethnicity, telephone, address, text, union, commercials_ask, nudity_ask, lingerie_ask, shows_ask, active', 'required'),
			array('agency_id, created_by, type_id, type2_id, active', 'numerical', 'integerOnly'=>true),
			array('agency_id, type2_id, characteristics', 'safe'),
			array('characteristics', 'characteristicsValidation'),
			
			array('video', 'required', 'on'=>'video'),
			array('video', 'unsafe'),
			array('video', 'file', 'allowEmpty' => true, 'types' => Yii::app()->getModule('agency')->getModule('models')->videosAllowedTypes, 'maxFiles' => 1),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fullname, letter', 'safe', 'on'=>'search'),
		);
	}
	
	public function characteristicsValidation($attribute,$params)
	{
		CharacteristicsHelper::characteristicsValidation($this,$attribute,$params);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'agency' => array(self::BELONGS_TO, 'Agencies', 'agency_id'),
			'type' => array(self::BELONGS_TO, 'AgencyTypes', 'type_id'),
			'type2' => array(self::BELONGS_TO, 'AgencyTypes', 'type2_id')
		);
	}
	
	public function getGallery()
	{
		Yii::app()->getModule('gallery');
		return Gallery::model()->findByAttributes(array('scope'=>'models','item_id'=>$this->id));
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
			'agency_id' => 'Agency',
			'type_id' => 'Primary Type',
			'type2_id' => 'Secondary Type',
			'telephone' => 'Phone number',
			'id' => 'ID'
		);
	}
	
	public function removeVideo($src = '')
	{
		$src = $src === ''? $this->video->source : $src;
		$m = Yii::app()->getModule('agency')->getModule('models');
		if(is_file( $path = Yii::getPathOfAlias('webroot').'/'.$m->videosPath.'/'.$src ))
			return @unlink($path);
		return false;
	}
	
	public function uploadVideo($fileInputName = 'video')
	{
		$attribute = 'video';
		
		unset($this->$attribute);
		
		if($filename_new = CUploadedFile::getInstance($this, $fileInputName))
		{
			$module = Yii::app()->getModule('agency')->getModule('models');
			$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$module->videosPath;
			Yii::app()->image->createImagesDirectory($filename_path);
			$filename = time() . '_' . $filename_new->getName();
			$old_video = self::model()->findByPk($this->id)->$attribute;
			if($old_video && $old_video->exists) { // delete old files
				$this->deleteVideo($old_video->source);
			}
			if(!$filename_new->saveAs($filename_path . DIRECTORY_SEPARATOR . $filename)) {
				return false;
			} else {
				$this->$attribute = $filename;
				return $this->update($attribute);
			}
		}
	}
	
	public static function getIdsByAgency($agency_id)
	{
		return Yii::app()->db->createCommand()
			->select('id')
			->from('models')
			->where('agency_id=:id', array(':id'=>$agency_id))
			->queryColumn();
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
		$criteria->compare('email',$this->email, true);
		$criteria->compare('telephone',$this->telephone, true);
		$criteria->compare("CONCAT(firstname, ' ', lastname)", $this->fullname, true);
		if($this->letter)
			$criteria->compare("SUBSTRING(lastname,1,1)", $this->letter);
		if($this->type_id)
			$criteria->addColumnCondition(array('type_id'=>$this->type_id, 'type2_id'=>$this->type_id), 'OR');
		//$criteria->compare('created_by',$this->created_by);
		//$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('active',$this->active);
		
		if(Yii::app()->user->isAgency())
			$criteria->compare('agency_id',Yii::app()->user->agency_id);
		elseif(Yii::app()->user->isBooker())
			$criteria->compare('agency_id',Yii::app()->user->agency_id);
		elseif(isset($_REQUEST['agency_id'])) {
			$criteria->compare('agency_id',$_REQUEST['agency_id']);
		}
		
		$sort = new CSort();
		$sort->defaultOrder = 'id DESC';
		$sort->attributes = array(
			'fullname' => array(
				'asc' => 'CONCAT(firstname, " ", lastname) ASC',
				'desc' => 'CONCAT(firstname, " ", lastname) DESC'
			),
			'email',
			'telephone',
			'type_id',
			'id'
		);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>false
		));
	}
	
	public function beforeSave()
	{
		if(in_array($this->scenario, array('insert', 'update')))
		{
			unset($this->video);

			if($this->scenario == 'insert') {
				$this->created_by = Yii::app()->user->id;
			} else { // update
				$this->updated_by = Yii::app()->user->id;
				$this->updated_time = new CDbExpression('NOW()');
				unset($this->created_time);
				unset($this->created_by);
			}
		}
		
		if(!Yii::app()->user->isAdmin())
			$this->agency_id = Yii::app()->user->agency_id;
		
		return parent::beforeSave();
	}
	
	public function afterConstruct()
	{
		if(!Yii::app()->user->isAdmin()) {
			$this->agency_id = Yii::app()->user->agency_id;
			$this->agency = Agencies::model()->findByPk($this->agency_id);
		}
	}
	
	public function afterFind()
	{
		$m = Yii::app()->getModule('agency')->getModule('models');
		
		// characteristics
		$this->characteristics = array();
		$db =& Yii::app()->db;
		$res = $db->createCommand("SELECT * FROM {{models_characteristics_values}} WHERE model_id=:model_id")
			->queryAll(true, array('model_id'=>$this->id));
		foreach($res as $c)
			$this->characteristics[$c['characteristic_id']] = $c['value'];
		
		// images
		$currentGalleryPath = Yii::app()->baseUrl.'/'.$m->videosPath;
		$currentSysGalleryPath = Yii::getPathOfAlias('webroot').'/'.$m->videosPath;
		
		if(is_file($currentSysGalleryPath.'/'.$this->video)) {
			$this->video = (object)array(
				'source' => $this->video,
				'full' => Yii::app()->baseUrl.'/'.$m->videosPath.'/'.$this->video,
				'exists' => true
			);
		} else {
			$this->video = (object)array(
				'source' => $this->video,
				'full' => Yii::app()->baseUrl.'/'.$m->videosPath.'/'.$this->video,
				'exists' => false
			);
		}
		
		// else
		$this->fullname = $this->firstname.' '.$this->lastname;
		$this->created_by_obj = User::model()->findByPk($this->created_by);
		$this->updated_by_obj = User::model()->findByPk($this->updated_by);
		
		parent::afterFind();
	}
	
	public function afterDelete()
	{
		parent::afterDelete();
	}
	
	public function afterSave()
	{
		$db =& Yii::app()->db;
		$db->createCommand("DELETE FROM {{models_characteristics_values}} WHERE model_id=:model_id")
			->bindParam('model_id', $this->id)
			->execute();
		
		$q = $db->createCommand("INSERT INTO {{models_characteristics_values}}(model_id, characteristic_id,value) VALUES (:model_id, :characteristic_id, :value)");
		foreach($this->characteristics as $cid => $value) {
			$q->bindParam('model_id', $this->id);
			$q->bindParam('characteristic_id', $cid);
			$q->bindParam('value', $value);
			$q->execute();
		}
		
		parent::afterSave();
	}
}