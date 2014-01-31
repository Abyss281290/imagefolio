<?php
Yii::import('zii.widgets.grid.CGridView');
Yii::import('ext.grid.ButtonColumn');
class GridView extends CGridView
{
		public $sortItems = false;
		/**
		 * keys:
		 *       [attributeName] - name of the request variable with selected letter
		 * @var mixed (boolean || array)
		 */
		public $filterLetters = false;
		public $filterLettersDefaults = array(
			'attributeName' => 'letter',
			'title' => ''
		);
		public $selectableRows = false;
		////
		
		public $template="{summary}\n{filterLetters}\n{items}\n{pager}";
		
		public $assetsPath;
		
	
	public function init()
	{
		$this->assetsPath = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets', false , -1, YII_DEBUG);
		
		if($this->sortItems) {
			$this->initRowsSorting();
		}
		
		Yii::app()->clientScript->registerCssFile($this->assetsPath.'/style.css');
		
		parent::init();
	}
	
	public function renderItems()
	{
		parent::renderItems();
	}
	
	public function renderFilter()
	{
		if($this->filter!==null)
		{
			echo "<tr class=\"{$this->filterCssClass}\">\n";
			
			if($this->sortItems) {
				echo '<td>&nbsp;</td>';
			}
			
			foreach($this->columns as $column)
				$column->renderFilterCell();
			echo "</tr>\n";
		}
	}
		
	public function renderTableHeader()
	{
		if(!$this->hideHeader)
		{
			echo "<thead>\n";

			if($this->filterPosition===self::FILTER_POS_HEADER)
				$this->renderFilter();

			echo "<tr>\n";
			
			if($this->sortItems) {
				echo '<th>Sortable</th>';
			}
			
			foreach($this->columns as $column)
				$column->renderHeaderCell();
			echo "</tr>\n";

			if($this->filterPosition===self::FILTER_POS_BODY)
				$this->renderFilter();

			echo "</thead>\n";
		}
		else if($this->filter!==null && ($this->filterPosition===self::FILTER_POS_HEADER || $this->filterPosition===self::FILTER_POS_BODY))
		{
			echo "<thead>\n";
			$this->renderFilter();
			echo "</thead>\n";
		}
	}
		
	public function renderTableRow($row)
	{
		if($this->rowCssClassExpression!==null)
		{
			$data=$this->dataProvider->data[$row];
			echo '<tr class="'.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$data)).'">';
		}
		else if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
			echo '<tr class="'.$this->rowCssClass[$row%$n].'">';
		else
			echo '<tr>';
		
		if($this->sortItems) {
			echo '<td style="width:1px; text-align:center">'.CHtml::image($this->assetsPath.'/move.png').'</td>';
		}
		
		foreach($this->columns as $column)
			$column->renderDataCell($row);
		echo "</tr>\n";
	}
	
	public function renderFilterLetters()
	{
		if(!$this->filterLetters)
			return;
		
		$this->filterLetters = (array)$this->filterLetters + $this->filterLettersDefaults;
		if(!$this->filterLetters['title'] && $this->filterLetters['title'] !== false)
			$this->filterLetters['title'] = 'Select char to filter by '.($this->filter->generateAttributeLabel($this->filterLetters['attributeName']));
		$attr = $this->filter->{$this->filterLetters['attributeName']};
		echo '<div class="filter-letters">';
		echo '<div class="title">'.$this->filterLetters['title'].'</div>';
		echo '	<ul>';
		echo CHtml::link('All', '#', array('rel'=>'','class'=>'item all'.(!$attr?' active':'')));
		for($i='a'; $i!='aa'; $i++) {
			echo CHtml::link($i, '#', array('rel'=>$i,'class'=>'item letter'.($attr==$i?' active':'')));
		}
		echo '	</ul>';
		echo CHtml::activeHiddenField($this->filter, $this->filterLetters['attributeName']);
		echo '</div>';
		
		$js = "jQuery('#{$this->id} .filter-letters a.item').live('click', function(){
			$(this).closest('div').find('input').val($(this).attr('rel'));
			$.fn.yiiGridView.update('{$this->id}', {data: $('#{$this->id} input').serialize()});
			return false;
		});";
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id, $js);
	}
	
	protected function initRowsSorting()
	{
		$id = $this->id;
		$css = "#$id table.items tbody tr{ cursor: move }";
		if(isset($this->sortItems['action'])) {
			$this->rowCssClassExpression = '$this->rowCssClass[$row%count($this->rowCssClass)]." items[]_{$data->id}"';
			$this->afterAjaxUpdate .= 'CGridSortable';
			$update = "
				function () {
						serial = $('#$id table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
						$.ajax({
							'url': '" .$this->sortItems['action'] . "',
							'type': 'post',
							'data': serial,
							'success': function(data){
							},
							'error': function(request, status, error){
								alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
							}
						});
					}
			";
		} else {
			$update = 'null';
		}
		$js = "
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					$(this).width($(this).width());
				});
				return ui;
			};

			function CGridSortable()
			{
				$('#$id table.items tbody').sortable({
					forcePlaceholderSize: true,
					forceHelperSize: true,
					items: 'tr',
					update : $update,
					helper: fixHelper,
					handle: 'td:first'
				});//.disableSelection();
			}
			CGridSortable();
		";
		Yii::app()->clientScript->registerCoreScript('jquery.ui');
		Yii::app()->clientScript->registerScript($id.'-sortable', $js);
		Yii::app()->clientScript->registerCss($id.'-sortable', $css);
	}
}
