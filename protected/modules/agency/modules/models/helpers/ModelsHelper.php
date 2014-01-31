<?php
class ModelsHelper
{
	public static function setModelUpdateMenu($model)
	{
		$controller = Yii::app()->controller;
		$modelsAssetPath = Yii::app()->getModule('agency')->getModule('models')->assetPath;
		$menu = array(
			array(
				'label'=>CHtml::image($modelsAssetPath.'/images/update.png').' Update Talent',
				'url'=>$controller->createUrl('/agency/models/admin/update',array('id'=>$model->id)),
				'active'=>$controller->action->id == 'update'
			),
			array(
				'label'=>CHtml::image(Yii::app()->baseUrl.'/images/gallery.png').' Gallery',
				'url'=>Yii::app()->getModule('gallery')->getAdminRoute("models", $model->id, "/agency/models/admin/index"),
				'active'=>$controller->module->id == 'gallery' && $_REQUEST['gallerycode'] == 0 
			),
			array(
				'label'=>CHtml::image($modelsAssetPath.'/images/polaroids.png').' Polaroids',
				'url'=>Yii::app()->getModule('gallery')->getAdminRoute("models", $model->id, "/agency/models/admin/index",1),
				'active'=>$controller->module->id == 'gallery' && $_REQUEST['gallerycode'] == 1
			),
			array(
				'label'=>CHtml::image($modelsAssetPath.'/images/covers.png').' Covers',
				'url'=>Yii::app()->getModule('gallery')->getAdminRoute("models", $model->id, "/agency/models/admin/index",2),
				'active'=>$controller->module->id == 'gallery' && $_REQUEST['gallerycode'] == 2
			),
			array(
				'label'=>CHtml::image(Yii::app()->baseUrl.'/images/video.png').' Video',
				'url'=>$controller->createUrl('/agency/models/admin/video',array('model_id'=>$model->id)),
				'active'=>$controller->action->id == 'video'
			)
		);
		$controller->menu = $menu;
	}
	
	public static function setModelsRequestsUpdateMenu($model)
	{
		$controller = Yii::app()->controller;
		$menu = array(
			array(
				'label'=>'Update Request',
				'url'=>$controller->createUrl('/agency/models/adminRequests/update',array('id'=>$model->id)),
				'active'=>$controller->action->id == 'update'
			),
			array(
				'label'=>CHtml::image(Yii::app()->baseUrl.'/images/gallery.png').' Images',
				'url'=>$controller->createUrl('/agency/models/adminRequests/images',array('request_id'=>$model->id)),
				'active'=>$controller->action->id == 'images'
			),
		);
		$controller->menu = $menu;
	}
	
	public static function createMinibook($model_id, $type)
	{
		Yii::app()->controller->widget('application.modules.agency.modules.models.widgets.minibook.Minibook', array(
			'model_id'=>$model_id,
			'type'=>$type
		));
	}
	
	public static function getMinibookUrl($model, $type)
	{
		return Yii::app()->createUrl('/agency/models/admin/createMinibook',array('model_id'=>$model->id, 'type' => '0'))
			.'/'.UrlTransliterate::cleanString($model->fullname, '_').'.pdf';
	}
}