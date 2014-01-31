<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Formatter
 *
 * @author Admin
 */
class Formatter extends CFormatter
{
	public function formatBooleanTick($value)
	{
		return CHtml::image(Yii::app()->baseUrl.'/images/notifications/'.($value ? 'tick' : 'cross').'.png');
	}
}

?>
