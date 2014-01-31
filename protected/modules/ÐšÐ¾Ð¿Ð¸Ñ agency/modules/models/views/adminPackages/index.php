<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Packages'
);
$this->title = 'Packages';
?>
<?php //echo CHtml::link('Create Package', array('create'), array('class'=>'button blue', 'style'=>'margin-bottom:10px')); ?>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('ext.grid.GridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{send}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
			'buttons'=>array(
				'send'=>array(
					'label'=>'Send package',
					'imageUrl'=>$this->module->assetPath.'/images/icon-send.png',
					'url'=>'Yii::app()->controller->createUrl("send",array("id"=>$data->id))'
				)
			)
		),
		'title',
		'updated_time',
		'id',
	),
)); ?>
