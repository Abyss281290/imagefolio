<?php

class ContentList extends CWidget
{
		public $category_id = -1;
		public $region_id = -1;
		public $limit = -1;
	
	public function init()
	{
		$module = Yii::app()->getModule('content');
		$model = new Content();
		
		$c = new CDbCriteria();
		if($this->category_id > -1)
			$c->addColumnCondition(array('category_id' => $this->category_id));
		if($this->region_id > -1)
			$c->addColumnCondition(array('region_id' => $this->region_id));
		$c->addColumnCondition(array('active' => 1));
		$c->limit = $this->limit;
		$c->order = 'created_time DESC';
		$items = $model->findAll($c);
		
		$tmp = new ContentCategories();
		$tmp = $tmp->findAll();
		$categories = array();
		foreach($tmp as $category)
			$categories[$category->id] = $category;
		
		$this->render('list', array(
			'categories' => $categories,
			'items' => $items
		));
	}
}