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
class Content extends CActiveRecord
{
		public $created_by_obj;
		public $updated_by_obj;
		public $image_remove;
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
		return 'content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		//$purifier = new CHtmlPurifier();
		/*$purifier->options = array(
			'HTML.SafeObject'=>true,
			'HTML.SafeEmbed'=>true
		);*/
		
		return array(
			array('name, title, content', 'required'),
			//array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg, gif, png, jpeg', 'maxFiles' => 1),
			//array('created_by, active, category_id', 'numerical', 'integerOnly'=>true),
			array('image_remove, short_content', 'safe'),
			array('seo_title, seo_keywords, seo_description', 'safe'),
			array('short_content, content', 'filter', 'filter'=>array(&$this, 'purifyContent')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, title, created_by, created_time, active', 'safe', 'on'=>'search'),
		);
	}
	
	public function purifyContent($string)
	{
		return preg_replace('#<script(.*?)>(.*?)</script>#is', '', $string);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'category' => array(self::BELONGS_TO, 'ContentCategories', 'category_id')
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
			'category_id' => 'Category',
			'region_id' => 'Region',
			'created_by' => 'Created By',
			'created_time' => 'Created Time',
			'active' => 'Active',
			'title' => 'Title',
			'content' => 'Content',
			'short_content' => 'Short content',
			
			'seo_title' => 'Title',
			'seo_keywords' => 'Keywords',
			'seo_description' => 'Description'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('active',$this->active);
		
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function removeImage($imageSrc = null)
	{
		$m = Yii::app()->getModule('content');
		$imageSrc = $imageSrc === null? $this->image->src['source'] : $imageSrc;
		$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$m->imagesPath;
		if(is_file( $path = $filename_path . DIRECTORY_SEPARATOR . $imageSrc ))
			return @unlink($path);
		return false;
	}
	
	public function beforeSave()
	{
		// process image
		unset($this->image);
		
		$attribute = 'image';
		if($filename_new = CUploadedFile::getInstance($this, $attribute))
		{
			$module = Yii::app()->getModule('content');
			$filename_path = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$module->imagesPath;
			Yii::app()->image->createImagesDirectory($filename_path);
			$filename = time() . '_' . $filename_new->getName();
			$old_image = @self::model()->findByPk($this->id)->$attribute->src['source'];
			if(!empty($old_image)) { // delete old files
				$this->removeImage($old_image);
			}
			if(!$filename_new->saveAs($filename_path . DIRECTORY_SEPARATOR . $filename)) {
				throw new CHttpException(400, 'File not saved. Please do not repeat this request again.');
			} else {
				if($module->imageResize) {
					$img = Yii::app()->image->load($filename_path.DIRECTORY_SEPARATOR.$filename);
					$img->resize($module->imageResize['width'], $module->imageResize['height'], Image::WIDTH);
					$img->quality($module->imageResize['quality']);
					$img->save();
				}
				$this->$attribute = $filename;
			}
		}
		elseif($this->image_remove)
		{
			$this->removeImage(@self::model()->findByPk($this->id)->$attribute->src['source']);
			$this->image = '';
		}
		
		if($this->scenario == 'insert') {
			$this->created_by = Yii::app()->user->id;
		} else { // update
			$this->updated_by = Yii::app()->user->id;
			$this->updated_time = new CDbExpression('NOW()');
			unset($this->created_time);
			unset($this->created_by);
		}
		
		return parent::beforeSave();
	}
	
	public function afterFind()
	{
		$this->created_by_obj = User::model()->findByPk($this->created_by);
		$this->updated_by_obj = User::model()->findByPk($this->updated_by);
		
		$m = Yii::app()->getModule('content');
		$currentGalleryPath = Yii::app()->baseUrl.'/'.$m->imagesPath;
		$currentSysGalleryPath = Yii::getPathOfAlias('webroot').'/'.$m->imagesPath;
		
		if(is_file($currentSysGalleryPath.'/'.$this->image)) {
			$this->image = (object)array(
				'sourceSrc' => $this->image,
				'src' => array(
					'source' => $this->image,
					'full' => Yii::app()->baseUrl.'/'.Yii::app()->getModule('content')->imagesPath.'/'.$this->image
				),
				'exists' => true
			);
		} else {
			$path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('content').'/assets/images/noimage.png');
			$this->image = (object)array(
				'sourceSrc' => 'noimage.png',
				'src' => array(
					'source' => $path,
					'full' => $path
				),
				'exists' => false
			);
		}
		
		parent::afterFind();
	}
	
	public function afterDelete()
	{
		$this->removeImage();
		parent::afterDelete();
	}
}