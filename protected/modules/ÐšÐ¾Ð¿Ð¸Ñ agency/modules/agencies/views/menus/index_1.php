<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Types',
);

$this->menu=array(
	array('label'=>'Create Type', 'url'=>array('create')),
	array('label'=>'Manage Type', 'url'=>array('admin')),
);

$this->title = 'Agency Menus';
?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<?php echo CHtml::link('Create Menu', array('create')); ?>

<?php $this->widget('ext.grid.GridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{update} {delete}',
		),
		'parent_id',
		'type_id',
		'id'
	),
)); ?>