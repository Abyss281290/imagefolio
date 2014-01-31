<?php
/**
 * Description of VideosItems
 *
 * @author Admin
 */
class VideosItems extends CActiveRecord
{
		public $id;
		public $gallery_id;
		public $src;
		public $ordering;
		
		public $image;
		public $video;

	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	public function tableName()
    {
        return 'videos_items';
    }

	public function relations()
    {
        return array(
            'videos' => array(self::BELONGS_TO, 'Videos', 'video_id'),
		);
	}
	
	public function afterFind()
	{
		$m = Yii::app()->getModule('videos');
		$v =& $this->videos;
		$currentGalleryPath = Yii::app()->baseUrl.'/'.$m->galleriesPath.'/'.$v->scope.'/'.$v->item_id;
		$currentSysGalleryPath = Yii::getPathOfAlias('webroot').'/'.$m->galleriesPath.'/'.$v->scope.'/'.$v->item_id;
		
		$this->image = (object)(file_exists($currentSysGalleryPath.'/images/'.$this->src.'.jpg')
			? array(
				'thumbPath' => $currentGalleryPath.'/images/'.$this->src.'_thumb.jpg',
				'fullPath' => $currentGalleryPath.'/images/'.$this->src.'.jpg',
			)
			: array(
				'thumbPath' => $m->assetPath.'/images/noimage.png',
				'fullPath' => $m->assetPath.'/images/noimage.png',
			));
		$this->video = (object)array(
			'path' => $currentGalleryPath.'/videos/'.$this->src.'.flv'
		);
		
		return true;
	}
	
	public function afterDelete()
	{
		$m = Yii::app()->getModule('videos');
		$db =& Yii::app()->db;
		// update images ordering
		$db->createCommand("UPDATE {{videos_items}} SET ordering = ordering - 1 WHERE ordering > ".$this->ordering." AND video_id = ".$this->video_id)->execute();
		// remove physical objects
		$currentSysGalleryPath = Yii::getPathOfAlias('webroot').'/'.$m->galleriesPath.'/'.$this->videos->scope.'/'.$this->videos->item_id;
		@unlink($currentSysGalleryPath.'/images/'.$this->src.'.jpg');
		@unlink($currentSysGalleryPath.'/images/'.$this->src.'_thumb.jpg');
		@unlink($currentSysGalleryPath.'/videos/'.$this->src.'.flv');
		/*foreach(array_keys($m->getSizes($this->gallery->scope)) as $size) {
			@unlink(Yii::getPathOfAlias('webroot').'/'.$m->galleriesPath.'/'.$this->gallery->scope.'/'.$this->gallery->item_id.'/'.$size.'/'.$this->src);
		}*/
		
		return true;
	}
}

?>