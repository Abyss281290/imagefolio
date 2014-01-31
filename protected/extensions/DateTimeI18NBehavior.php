<?php

/*
 * DateTimeI18NBehavior
 * Automatically converts date and datetime fields to I18N format
 *
 * Author: Ricardo Grana <rickgrana@yahoo.com.br>, <ricardo.grana@pmm.am.gov.br>
 * Version: 1.1
 * Requires: Yii 1.0.9 version
 */

class DateTimeI18NBehavior extends CActiveRecordBehavior
{
	public $dateOutcomeFormat = 'Y-m-d';
	public $dateTimeOutcomeFormat = 'Y-m-d H:i:s';

	public $dateIncomeFormat = 'yyyy-MM-dd';
	public $dateTimeIncomeFormat = 'yyyy-MM-dd hh:mm:ss';

	public $timeFields = array('date', 'datetime', 'timestamp');

	public function beforeSave($event){

		//search for date/datetime columns. Convert it to pure PHP date format
		foreach($event->sender->tableSchema->columns as $columnName => $column){
			if ($event->sender->$columnName instanceof CDbExpression) continue;
			if (!in_array($column->dbType, $this->timeFields)) continue;
			if (!strlen($event->sender->$columnName)){
				$event->sender->$columnName = null;
				continue;
			}
			if (($column->dbType == 'date')) {
				$timestamp = CDateTimeParser::parse($event->sender->$columnName, Yii::app()->locale->dateFormat);
				if($timestamp === false) {
					$timestamp = strtotime($event->sender->$columnName);
				}
				$event->sender->$columnName = date($this->dateOutcomeFormat, $timestamp);
			}else{
				$pattern = strtr(Yii::app()->locale->dateTimeFormat, array(
					'{0}' => Yii::app()->locale->timeFormat,
					'{1}' => Yii::app()->locale->dateFormat
				));
				$timestamp = CDateTimeParser::parse($event->sender->$columnName, $pattern);
				if($timestamp === false) {
					$timestamp = strtotime($event->sender->$columnName);
				}
				$event->sender->$columnName = date($this->dateTimeOutcomeFormat, $timestamp);
			}
		}
		return true;
	}

	public function afterFind($event){

		foreach($event->sender->tableSchema->columns as $columnName => $column){
			if (!in_array($column->dbType, $this->timeFields)) continue;

			if (!strlen($event->sender->$columnName) || $event->sender->$columnName == '0000-00-00 00:00:00') {
				$event->sender->$columnName = null;
				continue;
			}

			if ($column->dbType == 'date') {
				$event->sender->$columnName = Yii::app()->dateFormatter->formatDateTime(
					CDateTimeParser::parse($event->sender->$columnName, $this->dateIncomeFormat), 'medium', null);
			}else{
				$event->sender->$columnName =
					Yii::app()->dateFormatter->formatDateTime(
						CDateTimeParser::parse($event->sender->$columnName,	$this->dateTimeIncomeFormat), 'medium', 'short');
			}
		}
		return true;
	}
}