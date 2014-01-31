<?php
Yii::import('ext.grid.GridView');
class ModelsTileGridView extends GridView
{
	public function run()
	{
		$this->registerClientScript();

		//echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";

		$this->renderContent();
		$this->renderKeys();

		//echo CHtml::closeTag($this->tagName);
	}
	
	public function renderFilter()
	{
		echo '<table style="width: auto">';
		if($this->filter!==null)
		{
			echo "<tr>\n";
			foreach($this->columns as $column) {
				$header = $column->header === NULL? $this->filter->getAttributeLabel($column->name) : $column->header;
				echo '<td>'.$header.'</td>';
			}
			echo "</tr>\n";
			echo "<tr>\n";
			foreach($this->columns as $column) {
				$column->renderFilterCell();
			}
			echo "</tr>\n";
		}
		echo '</table>';
	}
}
