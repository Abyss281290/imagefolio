<?php

class DefaultController extends Controller
{
	public function accessRules()
	{
		return array(
			array('deny',
				'actions'=>array('index'),
				'expression'=>'AgencyModule::getAgency('.(int)$_REQUEST['agency_id'].')->isPaid() == false',
				'users'=>array('*'),
			),
			array('deny',
				//'actions'=>array('view'),
				'expression'=>function() {
					$model_id = isset($_REQUEST['id'])? $_REQUEST['id'] : $_REQUEST['model_id'];
					if($model_id) {
						$model = Models::model()->findByPk($model_id);
						return $model->agency->isPaid() == false;
					} else {
						return false;
					}
				},
				'users'=>array('*'),
			)
		);
	}
	
	public function actionIndex($agency_id, $type_id)
	{
		$agency = Agencies::model()->findByPk($agency_id);
		if($agency===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		AgencyFrontHelper::initAgency($agency);
		
		$model = new Models('search');
		if(isset($_GET['Models']))
			$model->attributes=$_GET['Models'];
		$model->agency_id = $agency_id;
		$model->type_id = $type_id;
		/*$models = $model->findAll('agency_id=:aid AND (type_id=:tid OR type2_id=:t2id) AND active=:a', array(
			'aid'=>$agency_id,
			'tid'=>$type_id,
			't2id'=>$type_id,
			'a'=>1
		));*/
		
		$type = AgencyTypes::model()->findbyPk($type_id);
		
		$this->render('index', array(
			'model' => $model,
			'agency' => $agency,
			//'models' => $models,
			'type' => $type
		));
	}
	
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		/*$characteristics = array();
		if($model->characteristics) {
			foreach($model->characteristics as $cid => $cval) {
				$c = AgencyCharacteristics::model()->findByPk($cid);
				if($c) {
					$characteristics[] = array(
						'title' => $c->title,
						'value' => CharacteristicsHelper::getElementValue($c, $cval)
					);
				}
			}
		}*/
		
		$galleryModule = Yii::app()->getModule('gallery');
		$gallery = Gallery::model()->findByAttributes(array(
			'scope' => 'models',
			'item_id' => $model->id,
			'gallerycode' => 0
		));
		$polaroids = Gallery::model()->findByAttributes(array(
			'scope' => 'models',
			'item_id' => $model->id,
			'gallerycode' => 1
		));
		$covers = Gallery::model()->findByAttributes(array(
			'scope' => 'models',
			'item_id' => $model->id,
			'gallerycode' => 2
		));
		// id => array(title, url, disabled)
		$menu = array(
			'polaroids' => array('Polaroids', '#', null, !$polaroids || !$polaroids->images),
			'video' => array('Video', $this->createUrl('video',array('model_id'=>$model->id)), null, !$model->video->exists),
			'covers' => array('Covers', '#', null, !$covers || !$covers->images),
			//'minibooks' => array('Minibooks', '#model-minibooks', false)
			'minibooks' => array('Minibooks', $this->createUrl('createMinibook', array('model_id'=>$model->id,'type'=>0)), array('target'=>'_blank'), false)
		);
		foreach($menu as $k=>$item)
			if($item[3])
				unset($menu[$k]);
		
		$this->render('view', array(
			'model' => $model,
			//'characteristics' => $characteristics,
			'galleryModule'=>$galleryModule,
			'gallery'=>$gallery,
			'polaroids'=>$polaroids,
			'covers'=>$covers,
			'menu'=>$menu,
		));
	}
	
	/*public function actionViewTileLoadImages($gallery_id, $offset, $limit)
	{
		$this->viewTileLoadImages($gallery_id, $offset, $limit);
	}
	
	public function viewTileLoadImages($gallery_id, $offset, $limit)
	{
		Yii::app()->getModule('gallery');
		$c = array(
			'condition'=>'gallery_id = :gid AND (public = 1 OR main = 1)',
			'params'=>array(':gid'=>$gallery_id),
		);
		$maxOffset = GalleryImage::model()->count($c);
		$offset = $offset < 0? 0 : ($offset > $maxOffset? $maxOffset : $offset);
		$c['offset'] = $offset;
		$c['limit'] = $limit;
		$c['order'] = 'ordering';
		$images = GalleryImage::model()->findAll($c, array('order'=>'main'));
		$this->renderPartial('view/tile_images', array('images'=>$images));
	}*/
	
	public function actionVideo($model_id)
	{
		$model = $this->loadModel($model_id);
		$this->renderPartial('video', array(
			'model'=>$model
		), false, true);
	}
	
	public function actionCreateMinibook($model_id, $type)
	{
		$model = $this->loadModel($model_id);
		ModelsHelper::createMinibook($model_id, $type);
		die();
	}
	
	public function loadModel($id)
	{
		$model=Models::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if(!$model->agency)
			throw new CHttpException(404,'The requested page does not exist.');
		
		AgencyFrontHelper::initAgency($model->agency);
		
		return $model;
	}
}