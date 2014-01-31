<?php
class T
{
	/**
	 * Yii app text alias function (category and message params reversed, by default category is 'global')
	 * @param type $message
	 * @param type $category
	 * @param type $params
	 * @param type $source
	 * @param type $language 
	 */
	function _($message, $category = 'main', $params=array(), $source=null, $language=null)
	{
		return Yii::t($category, $message, $params, $source, $language);
	}
}