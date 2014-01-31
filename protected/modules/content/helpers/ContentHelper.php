<?php
class ContentHelper
{
	public static function getCategoriesIdTitle()
	{
		$criteria = new CDbCriteria(array('order' => 'title'));
		$regions = ContentCategories::model()->findAll($criteria);
		$re = array();
		foreach($regions as $region) {
			$re[$region->id] = $region->title;
		}
		return $re;
	}
	
	public static function loadModel($id)
	{
		$model = new Content();
		$model = $model->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist');
		
		$app =& Yii::app();
		$cs =& $app->clientScript;
		$c =& $app->controller;
		$c->pageTitle = $model->seo_title;
		$cs->registerMetaTag($model->seo_keywords, 'keywords');
		$cs->registerMetaTag($model->seo_description, 'description');
		
		return $model;
	}
}

?>
