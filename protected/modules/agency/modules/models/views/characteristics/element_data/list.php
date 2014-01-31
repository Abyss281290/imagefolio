<?php echo CHtml::button('Add value', array('onclick'=>'charsList.add()', 'class'=>'button small')); ?>
<?php
//$items = array();
//foreach($model->data as $k=>$v)
//	$items[] = array('value'=>$k,'title'=>$v);

$grid = $this->widget('ext.grid.GridView', array(
	'id'=>'data-grid',
    'dataProvider'=>new CArrayDataProvider((array)$model->data, array(
			'keyField'=>'value',
			'pagination'=>array('pageSize'=>count($model->data)),
		)
	),
	'sortItems'=>true,
    'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'',
			'template'=>'{delete}',
			'buttons'=>array(
				'delete'=>array(
                    'label'=> Yii::t('main', 'Change Status'),
                    //'url'=>'#',
					'click' => 'charsList.remove',
                ),
			),
		),
		array(
			'name'=>'Value',
			'value'=>'CHtml::textField("'.CHtml::activeName($model, 'data').'[$row][value]", $data["value"], array("style"=>"width:93%"))',
			'type'=>'raw'
		),
		/*array(
			'name'=>'Title',
			'value'=>'CHtml::textField("'.CHtml::activeName($model, 'data').'[$row][title]", $data["title"])',
			'type'=>'raw'
		)*/
	)
));
?>
<script type="text/javascript">
var charsList = {
		name: '<?php echo CHtml::activeName($model, 'data'); ?>',
		baseUrl: '<?php echo $grid->baseScriptUrl; ?>',
		index: <?php echo count($model->data); ?>,
	
	add: function()
	{
		var table = $('#data-grid .items');
		
		if(this.index <= 0)
			table.find('tr:last').remove();
		
		var name = this.name+'['+this.index+']';
		var tr = '';
		tr += '<tr>';
		tr += '<td>&nbsp;</td>';
		tr += '<td class="button-column">';
		tr +=	'<a href="#" class="delete">'
		tr +=		'<img src="'+this.baseUrl+'/delete.png">';
		tr +=	'</a>';
		tr += '</td>';
		tr += '<td><input type="text" name="'+name+'[value]" style="width: 93%"></td>';
		//tr += '<td><input type="text" name="'+name+'[title]"></td>';
		tr += '</tr>';
		table.append(tr);
		
		this.index++;
		
		return false;
	},
	
	remove: function()
	{
		$(this).closest('tr').remove();
		
		this.index--;
		
		return false;
	}
}
</script>