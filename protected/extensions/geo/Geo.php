<?php

class Geo extends CWidget
{
		public $assetPath;
		public $names = array();
		public $select = array();
		public $model = null;
	
	public function init()
	{
		$this->names += array(
			'countries' => 'country',
			'cities' => 'city',
		);
		$this->assetPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.geo.assets'), false, -1, YII_DEBUG);
		
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($this->assetPath.'/geo.js');
		
		Yii::import('ext.geo.GeoHelper');
	}
	
	public function dropDownLists()
	{
		$getDataUrl = Yii::app()->controller
			? Yii::app()->controller->createUrl('geo_getData')
			: Yii::app()->createUrl('/site/geo_getData');
		$selects = array();
		$data = GeoHelper::getDropDownListData('countries');
		$child_id = $this->model
			? CHtml::activeId($this->model, $this->names['cities'])
			: CHtml::getIdByName($this->names['cities']);
		$options = array(
			'ajax' => array(
				'url' => $getDataUrl,
				'data' => 'js:"what=cities&parent_id="+this.value',
				'type' => 'post',
				'beforeSend' => 'function()
				{
					$("#'.$child_id.'").before(\'<img src="'.Yii::app()->baseUrl.'/images/loading1.gif" id="'.$child_id.'_loader">\').css("visibility", "hidden");
				}',
				'success' => 'function(r)
				{
					GeoWidget.afterAjax(r, "'.$child_id.'");
				}'
			),
			'empty' =>'- select country -'
		);
		$selected_country = $this->model? $this->model->attributes[$this->names['countries']] : $this->select['countries'];
		$selects['countries'] = $this->model
			? CHtml::activeDropDownList($this->model, $this->names['countries'], $data, $options)
			: CHtml::dropDownList($this->names['countries'], $this->select['countries'], $data, $options);
		
		$data = $selected_country
			? GeoHelper::getDropDownListData('cities', $selected_country)
			: array();
		$options = array(
			'empty' =>'- select city -'
		);
		$selects['cities'] = $this->model
			? CHtml::activeDropDownList($this->model, $this->names['cities'], $data, $options)
			: CHtml::dropDownList($this->names['countries'], $this->select['cities'], $data, $options);
		return $selects;
	}
}