<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Bookers'
);
$this->title = 'Manage Bookers';
?>
<?php echo CHtml::link('Create Booker', array('create'), array('class'=>'button blue','style'=>'margin-bottom:10px')); ?>
<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> */ ?>
<?php $this->widget('ext.grid.GridView', array(
	'id'=>'agency-bookers-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{update}&nbsp;&nbsp;{delete}',
		),
		//'agency_id',
		'email',
		'fullname',
		'telephone',
		//'id',
	),
)); ?>