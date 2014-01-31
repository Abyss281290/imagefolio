<?php
/**
 * Description of Image
 *
 * @author Admin
 */
class GalleryImage extends CActiveRecord
{
		public $id;
		public $gallery_id;
		public $src;
		public $crop_data;
		public $ordering;
		
		public $srcSource;
		public $srcOriginal;

	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	public function tableName()
    {
        return 'galleries_images';
    }

	public function relations()
    {
        return array(
            'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
		);
	}
	
	public function getSysGalleryPath()
	{
		return Yii::getPathOfAlias('webroot').'/'.Yii::app()->getModule('gallery')->galleriesPath.'/'.$this->gallery->scope.'/'.$this->gallery->item_id;
	}
	
	/*
	public function crop()
	{
		$m = Yii::app()->getModule('gallery');
		// resize new images
		$tempDir = Yii::getPathOfAlias('webroot').'/'.$m->tmpPath;
		$currentGalleryPath = $this->getSysGalleryPath();
		$tmpImage = $tempDir.'/'.$this->srcSource;
		copy($currentGalleryPath.'/'.$this->srcSource, $tmpImage);
		$i = Yii::app()->image->load($tmpImage);
		$i->crop($coords['w'], $coords['h'], $coords['y'], $coords['x']);
		$i->save();
		$this->makeImageSizes($tmpImage, $this->srcSource);
		@unlink($tmpImage);

		// update image data
		$this->crop_data = serialize(array(
			'x'=>$coords['x'],
			'y'=>$coords['y'],
			'x2'=>$coords['x2'],
			'y2'=>$coords['y2'],
			'w'=>$coords['w'],
			'h'=>$coords['h']
		));
		$this->update(array('crop_data'));
	}
	*/
	/**
	 * Works with "ext.cropzoom.JCropZoom"
	 * params must be in the $_POST array
	 */
	public function cropZoom($data)
	{
		Yii::import('ext.cropzoom.JCropZoom');
		$tmpPath = Yii::getPathOfAlias('webroot').'/'.Yii::app()->getModule('gallery')->tmpPath.'/'.$this->srcSource;
		copy($this->getSysGalleryPath().'/'.$this->srcSource, $tmpPath);
		$data['imageSource'] = $tmpPath;
		JCropZoom::getHandler()->process($data, $tmpPath);
		$this->makeImageSizes($tmpPath, $this->srcSource);
		@unlink($tmpPath);
		$this->crop_data = $data;
		unset($this->crop_data['imageSource']);
		$this->crop_data = serialize($this->crop_data);
		$this->update(array('crop_data'));
	}
	
	public function makeImageSizes($originalImagePath, $newImgName)
	{
		$currentGalleryPath = $this->getSysGalleryPath();
		$imageSize = getimagesize($originalImagePath);
		foreach(Yii::app()->getModule('gallery')->getSizes($this->gallery->scope) as $size => $sizeParams) {
			// if image is smaller then sizes, then skip resizing
			// width, height, quality
			$img = Yii::app()->image->load($originalImagePath);
			if($sizeParams) {
				$sizeParams += array(0, 0, 100);
				if($imageSize[1] > $sizeParams[1]) {
					$img->resize($sizeParams[0], $sizeParams[1], Image::HEIGHT);
					$img->quality($sizeParams[2]);
				}
			}
			$img->save($currentGalleryPath.'/'.$size.'/'.$newImgName);
		}
	}
	
	public function beforeDelete()
	{
		$m = Yii::app()->getModule('gallery');
		$db =& Yii::app()->db;
		// update images ordering
		$db->createCommand("UPDATE {{galleries_images}} SET ordering = ordering - 1 WHERE ordering > ".$this->ordering." AND gallery_id = ".$this->gallery_id)->execute();
		$galleryPath = $this->getSysGalleryPath();
		// remove original image
		@unlink($galleryPath.'/'.$this->srcSource);
		// remove sizes
		foreach(array_keys($m->getSizes($this->gallery->scope)) as $size) {
			@unlink($galleryPath.'/'.$size.'/'.$this->srcSource);
		}
		
		return parent::beforeDelete();
	}
	
	public function afterFind()
	{
		$m = Yii::app()->getModule('gallery');
		$currentGalleryPath = Yii::app()->baseUrl.'/'.$m->galleriesPath.'/'.$this->gallery->scope.'/'.$this->gallery->item_id;
		$currentSysGalleryPath = $this->getSysGalleryPath();
		$fe = file_exists($currentSysGalleryPath.'/'.key($m->getSizes($this->gallery->scope)).'/'.$this->src);
		if(!$fe && !$m->showNoimageDummy) {
			/**
			 * @TODO: delete image from database if not exists physically
			 */
			$this->src = null;
			return;
		}
		$this->srcSource = $this->src;
		// original
		$this->srcOriginal = $currentGalleryPath.'/'.$this->srcSource;
		// sizes
		$this->src = array();
		foreach(array_keys($m->getSizes($this->gallery->scope)) as $size)
			$this->src[$size] = $fe
				? $currentGalleryPath.'/'.$size.'/'.$this->srcSource
				: Yii::app()->assetManager->publish(Yii::getPathOfAlias('gallery').'/assets/images/noimage.png');
		
		// crop coords
		$this->crop_data = unserialize($this->crop_data);
		if(!is_array($this->crop_data))
			$this->crop_data = array();
		
		parent::afterFind();
	}
}

?>