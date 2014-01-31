<?php
/**
 * Description of Gallery
 *
 * @author Admin
 */
class Gallery extends CActiveRecord
{
		public $id;
		public $scope;
		public $item_id;
		public $returnUrl;
		public $gallerycode;
		
		public $options;
		
		public $agencyModel;

	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	public function init()
	{
		$this->scope = @$_REQUEST['scope'];
		$this->item_id = @intval($_REQUEST['item_id']);
		$this->gallerycode = @intval($_REQUEST['gallerycode']);
		$this->returnUrl = isset($_REQUEST['returnUrl'])? urldecode($_REQUEST['returnUrl']) : '';
		
		// set gallery owner info
		$this->options = array(
			'title' => 'Gallery',
			'breadcrumbs' => array()
		);
		switch($this->scope)
		{
			case 'content':
				$this->options['breadcrumbs'] = array(
					Yii::app()->getModule('content')->title,
					Content::model()->findByPk($this->item_id)->title,
					'Gallery'
				);
				break;
			case 'models':
				Yii::app()->getModule('agency')->getModule('models');
				$model = Models::model()->findByPk($this->item_id);
				ModelsHelper::setModelUpdateMenu($model);
				ModelsPackagesHelper::addTrigger();
				$this->options['breadcrumbs'] = array(
					'Agency'=>array('/agency/admin'),
					'Models'=>array('/agency/models/admin'),
					$model->fullname=>array('/agency/models/admin/update/id/'.$this->item_id),
					'Gallery'
				);
				$this->agencyModel = $model;
				break;
		}
	}

	public function rules()
	{
		return array(
			array('scope, item_id,gallerycode', 'required')
		);
	}

	public function tableName()
    {
        return 'galleries';
    }

	public function relations()
    {
        return array(
            'images' => array(self::HAS_MANY, 'GalleryImage', 'gallery_id', 'order' => 'ordering'),
			'imagesPublic' => array(self::HAS_MANY, 'GalleryImage', 'gallery_id', 'order' => 'ordering', 'condition'=>'public=1 OR main=1'),
			'maxOrdering' => array(self::STAT, 'GalleryImage', 'gallery_id', 'select' => 'MAX(ordering)')
		);
	}
	
	public function getMainImage($size, $falseIfNotExists = false, $images = null)
	{
		if($images === null)
			$images = $this->images;
		$galleryModule = Yii::app()->getModule('gallery');
		$mainGalleryImage = GalleryImage::model()->findByAttributes(array('gallery_id'=>$this->id,'main'=>1));
		if($mainGalleryImage)
			return $mainGalleryImage->src[$size];
		else
			return $images? $images[0]->src[$size] : ($falseIfNotExists? false : $galleryModule->noImage);
	}
	
	public function afterFind()
	{
		return;
		$m = Yii::app()->getModule('gallery');
		$images = array();
		foreach($this->images as $i => $item) {
			$fe = file_exists($currentSysGalleryPath.'/'.key($m->getSizes($this->scope)).'/'.$item->src);
			if(!$fe && !$m->showNoimageDummy) {
				/**
				 * @TODO: delete image from database if not exists physically
				 */
				continue;
			}
			$images[] = $item;
		}
		$this->images = $images;
	}

	public static function loadFromRequest()
	{
		$model = new Gallery();
		if(isset($_REQUEST['scope']) && isset($_REQUEST['item_id'])) {
			$result = $model->findByAttributes(array('scope'=>$_REQUEST['scope'], 'item_id'=>$_REQUEST['item_id'], 'gallerycode'=>$_REQUEST['gallerycode']));
			if($result)
				$model = $result;
			else
				$model->attributes = $_REQUEST;
		}
		return $model;
	}
	
	public function createMinibook()
	{
		
		$cnt = 0;
		$html = "<html><head></head><body>";
		$model = Models::model()->findByPk($_REQUEST["item_id"]);
		$fullname = $model->fullname;
		foreach($this->images as $item)
		{
			//todo: only add "public" images to a minibook
			
			switch($this->gallerycode) {
				case 0:
					if($item->main) {
						$src_large = $item->src["large"];
						$src_small = array();
					}
					//Yii::import('application.views.layouts.*');
					else {
						if($cnt <= 3) $src_small[] = $item->src["medium"];
					}
				break;
				case 1:
				break;
				case 2:
				break;
			}
			
			//var_dump($item->src["large"]);
			$cnt++;
		}
		switch($this->gallerycode) {
			case 0:
			default:
				$html = "<table width=\"100%\" height=\"480px\" border=\"0\" style=\"padding-top: 60px;\"> <tr>
										<td style=\"text-align: center; width:35%;\"><img src=\"{$src_large}\"  height=480px;/></td>
										<td valign=\"bottom\">";
				$html .= "<table border=\"0\" ><tr><td colspan=\"3\" align=\"center\" style=\"height: 200px; vertical-align: top;\"><p style=\"font-size:32pt; \">{$fullname}</p></td></tr>
				<tr>";
					foreach($src_small as $src) {
					
						$html .= "<td style=\"text-align: center; height: 186px;\"><img style=\"padding-left: 65px;\" src=\"{$src}\"/></td>";
					}
					$html .= "</td></tr></table>";
				$html .= "</td></tr></table>";
			
			break;
			case 1:
			break;
			case 2:
			break;
		}
		$html .= "</body></html>";
		return $html;
		
	}
	
}
?>
