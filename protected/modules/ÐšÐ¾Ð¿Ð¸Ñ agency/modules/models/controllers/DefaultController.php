<?php

class DefaultController extends Controller
{
	public function actionIndex($agency_id, $type_id)
	{
		$agency = Agencies::model()->findByPk($agency_id);
		if($agency===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		AgencyFrontHelper::initAgency($agency);
		
		$models = Models::model()->findAll('agency_id=:aid AND (type_id=:tid OR type2_id=:t2id) AND active=:a', array(
			'aid'=>$agency_id,
			'tid'=>$type_id,
			't2id'=>$type_id,
			'a'=>1
		));
		
		$type = AgencyTypes::model()->findbyPk($type_id);
		
		$this->render('index', array(
			'agency' => $agency,
			'models' => $models,
			'type' => $type
		));
	}
	
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		$characteristics = array();
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
		}
		
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
			'polaroids' => array('Polaroids', '#', !$polaroids),
			'video' => array('Video', $this->createUrl('video',array('model_id'=>$model->id)), !$model->video->exists),
			'covers' => array('Covers', '#', !$covers),
			'minibooks' => array('Minibooks', '#model-minibooks', false)
		);
		
		$this->render('view', array(
			'model' => $model,
			'characteristics' => $characteristics,
			'galleryModule'=>$galleryModule,
			'gallery'=>$gallery,
			'polaroids'=>$polaroids,
			'covers'=>$covers,
			'menu'=>$menu,
		));
	}
	
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