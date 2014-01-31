<?php
/**
 * Description of Videos
 *
 * @author Admin
 */
class Videos extends CActiveRecord
{
		public $id;
		public $scope;
		public $item_id;
		public $returnUrl;
		public $owner;
		
		public $video;
		public $image;

	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	public function init()
	{
		$this->scope = @$_REQUEST['scope'];
		$this->item_id = @intval($_REQUEST['item_id']);
		$this->returnUrl = isset($_REQUEST['returnUrl'])? urldecode($_REQUEST['returnUrl']) : '';

		// set gallery owner info
		$this->owner = (object)array(
			'title' => 'Undefined scope',
			'itemTitle' => 'undefined item',
			'exists' => false
		);
		switch($this->scope)
		{
			case 'content':
				$this->owner->title = Yii::app()->getModule('content')->title;
				$this->owner->itemTitle = Content::model()->findByPk($this->item_id)->title;
				$this->owner->exists = true;
				break;
		}
	}

	public function rules()
	{
		return array(
			array('scope, item_id', 'required'),
			array('video', 'file', 'types'=>'flv'),
			array('image', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>true)
		);
	}
	
	public function tableName()
    {
        return 'videos';
    }

	public function relations()
    {
        return array(
            'videos_items' => array(self::HAS_MANY, 'VideosItems', 'video_id', 'order' => 'ordering'),
			'maxOrdering' => array(self::STAT, 'VideosItems', 'video_id', 'select' => 'MAX(ordering)')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'image' => 'Thumbnail'
		);
	}
	
	public static function loadFromRequest()
	{
		$model = new Videos();
		if(isset($_REQUEST['scope']) && isset($_REQUEST['item_id'])) {
			$result = $model->findByAttributes(array('scope'=>$_REQUEST['scope'], 'item_id'=>$_REQUEST['item_id']));
			if($result)
				$model = $result;
			else
				$model->attributes = $_REQUEST;
		}
		return $model;
	}
}
?>