<?php
class CharacteristicsHelper
{
	public static function getElementTypes($type = '')
	{
		$types = array(
			'list'      => 'List',
			'textarea'  => 'Free text',
			'html'      => 'HTML',
			'textfield' => 'Text field',
			'link'      => 'Link'
		);
		return $type === ''
			? $types
			: (isset($types[$type])? $types[$type] : null);
	}
	
	public static function renderElementTypeLabel($model, $activeModel, $attributeWithValues)
	{
		$id = CHtml::activeId($activeModel, $attributeWithValues.'['.$model->id.']');
		echo CHtml::label(CHtml::encode($model->title),$id,array('required'=>false));
	}
	
	//public static function renderElementType($model, $type, $data = '', $htmlOptions = array())
	public static function renderElementType($model, $activeModel, $attributeWithValues)
	{
		//$model->data = unserialize($model->data);
		$model->data = $model->data? $model->data : array();
		$name = CHtml::activeName($activeModel, $attributeWithValues.'['.$model->id.']');
		$value = isset($activeModel[$attributeWithValues][$model->id])? $activeModel[$attributeWithValues][$model->id] : '';
		$htmlOptions = array();
		
		if($model->type == 'html' && !Yii::app()->controller->isAdmin()) {
			$model->type = 'textarea';
		}
		
		switch($model->type)
		{
			case 'list':
				$data = CHtml::listData($model->data, 'value','title');
				echo CHtml::dropDownList($name, $value, $data, array('empty'=>'- Not selected -'));
				break;
			case 'textarea':
				$htmlOptions += array(
					'rows' => 5,
					'cols' => 55
				);
				echo CHtml::textArea($name, $value, $htmlOptions);
				break;
			case 'html':
				Yii::app()->controller->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
					//'model' => $model,
					//'attribute' => $name,
					'name' => $name,
					'value' => $value,
					'options' => array(
						'imageUpload' => Yii::app()->createUrl('/imperavi/imageUpload')
					),
					'htmlOptions' => array(
						'style'=>'width:470px; height: 250px'
					)
				));
				break;
			case 'textfield':
				$htmlOptions = array(
					'size' => 60
				);
				echo CHtml::textField($name, $value, $htmlOptions);
				break;
			case 'link':
				$htmlOptions = array(
					'size' => 60
				);
				echo CHtml::textField($name, $value, $htmlOptions);
				break;
		}
	}
	
	public static function characteristicsValidation($model,$attribute,$params)
	{
		foreach($model->$attribute as $attr_id => $attr_val) {
			if(strval($attr_val) === '') {
				$char = AgencyCharacteristics::model()->findByPk($attr_id);
				$model->addError($attribute, CHtml::encode($char->title).' cannot be empty');
			}
		}
	}
	
	public static function getElementValue($model, $value)
	{
		switch($model->type)
		{
			case 'list':
				$data = CHtml::listData($model->data, 'value','title');
				return isset($data[$value])? $data[$value] : $value;
				break;
			case 'link':
				if(strpos($value, '@') !== false)
					$href = 'mailto:'.$value;
				elseif(strpos($value, 'http://') === false)
					$href = 'http://'.$value;
				else
					$href = $value;
				return CHtml::link($value, $href, array('target'=>'_blank'));
				break;
			default:
				return $value;
				break;
		}
	}
	
}
