<?php
class ModelsPackagesHelper
{
	public static function getListData($agency_id = null)
	{
		$c = array(
			'order'=>'title'
		);
		if($agency_id) {
			$c['condition'] = 'agency_id = :aid';
			$c['params'] = array(':aid'=>$agency_id);
		}
		return CHtml::listData(ModelsPackages::model()->findAll($c), 'id', 'title');
	}
	
	public static function addTrigger()
	{
		if(Yii::app()->user->isAgencyMember() && AgencyModule::isAgencyHasPlanOption("packages")) {
			$m = Yii::app()->getModule('agency')->getModule('models');
			$c = Yii::app()->controller;
			Yii::app()->clientScript->registerScriptFile($m->assetPath.'/js/make-package.js');
			$c->widget('ext.colorbox.JColorBox');
			$c->addTrigger('Make package',$c->createUrl('/agency/models/adminPackages/make'),array(
				'onclick'=>'jQuery(this).colorbox(); return false'
			));
		}
	}
	
	public static function getFrontViewLink($model)
	{
		return Yii::app()->createAbsoluteUrl('agency/models/packages/view/',array('hash'=>$model->hash));
	}
}