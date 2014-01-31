<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Payment Packages'
);
$this->title = 'Payment Packages';
?>

<?php echo CHtml::link('Create Package', array('create'), array('class'=>'button blue', 'style'=>'margin-bottom:10px')); ?>
<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> */ ?>
<?php
$columns = array();
$columns[] = array(
	'class'=>'ButtonColumn',
	'header'=>'Action',
	//'template'=>'{menus}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{active}{unactive}',
	'template'=>'{update}&nbsp;&nbsp;{delete}',
);
$columns[] = 'title';
$columns[] = 'models_allowed';
$columns[] = array(
	'name'=>'price',
	'value'=>'"$".number_format($data->price,2)'
);
$columns[] = array(
	'name'=>'website',
	'type'=>'booleanTick',
	'htmlOptions'=>array('class'=>'center')
);
$columns[] = array(
	'name'=>'packages',
	'type'=>'booleanTick',
	'htmlOptions'=>array('class'=>'center')
);
$columns[] = array(
	'name'=>'submissions',
	'type'=>'booleanTick',
	'htmlOptions'=>array('class'=>'center')
);
$columns[] = 'images_allowed';
$columns[] = 'id';
$this->widget('ext.grid.GridView', array(
	'id'=>'agency-plans-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>$columns,
)); ?>
