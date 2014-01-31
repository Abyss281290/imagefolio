<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Models Requests'
);

$this->title = 'Models Requests';
?>
<?php echo CHtml::link('Create Request', array('create'), array('class'=>'button blue','style'=>'margin-bottom:10px')); ?>
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>
<?php
$this->widget('ext.grid.GridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterLetters'=>array(
		'title'=>'Please select char to filter by Last name'
	),
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{gallery} {update} {delete}',
			'buttons'=>array(
                'gallery'=>array(
                    'label' => 'Images',
					'imageUrl' => Yii::app()->request->baseUrl.'/images/gallery.png',
                    'url' => 'Yii::app()->controller->createUrl("images", array("request_id" => $data->id))',
                ),
			)
		),
		'name',
		'email',
		'telephone',
		'telephone2',
		array(
			'name' => 'type_id',
			'header' => 'Types',
			'value' => '$data->type->title.($data->type2? ", ".$data->type2->title : "")',
			'filter'=>CHtml::listData(AgencyTypes::model()->findAll('active=1'), 'id', 'title')
			//'type' => 'raw',
		),
		'id'
	),
));
?>