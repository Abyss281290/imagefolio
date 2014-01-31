<?php

class AgenciesHelper
{
	public static function getPageLayouts()
	{
		return array(
			'tile' => (object)array(
				'title' => 'Tile',
				'image' => self::getLayoutPreviewImage('tile')
			),
			'horizontal' => (object)array(
				'title' => 'Horizontal',
				'image' => self::getLayoutPreviewImage('horizontal')
			),
		);
	}
	
	public static function getLayoutPreviewImage($layout)
	{
		return Yii::app()->getModule('agency')->getModule('agencies')->assetPath.'/images/layouts-preview/'.$layout.'.png';
	}
	
	public static function getThemeColors()
	{
		return array('blue', 'dark', 'green', 'orange', 'red');
	}
	
	public static function getThemeColorsForDropDownList()
	{
		return array_combine(self::getThemeColors(), array_map('ucfirst', self::getThemeColors()));
	}
}

?>