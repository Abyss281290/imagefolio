<?php
$this->breadcrumbs=array(
	'Config',
);

$this->title = 'Config';
?>
<?php //echo CHtml::link('Create Request', array('create'), array('class'=>'button blue','style'=>'margin-bottom:10px')); ?>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php
$this->widget('ext.grid.GridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{update}',
			'buttons'=>array(
				'class'=>'ButtonColumn',
				'update'=>array('url'=>'Yii::app()->controller->createUrl("update",array("key"=>$data->key))')
			)
		),
		array(
			'name'=>'key',
			'htmlOptions'=>array('width'=>'30%')
		),
		array(
			'name'=>'value',
			'filter'=>false,
			'value'=>'Yii::app()->config->get($data->key)'
		),
	),
));
?>