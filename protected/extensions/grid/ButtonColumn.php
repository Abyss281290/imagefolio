<?php

class ButtonColumn extends CButtonColumn
{
	
	protected function initDefaultButtons()
	{
		if($this->deleteButtonImageUrl===null)
			$this->deleteButtonImageUrl=$this->grid->assetsPath.'/delete.png';
		if($this->viewButtonImageUrl===null)
			$this->viewButtonImageUrl=$this->grid->assetsPath.'/view.png';
		
		parent::initDefaultButtons();
	}
}