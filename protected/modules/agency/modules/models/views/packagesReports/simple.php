<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Packages'=>array('adminPackages/index'),
	'Simple Reports'
);

$this->title = 'Packages Simple Reports';

$user = Yii::app()->user;

$filterDatePickerOptions = array(
	'changeMonth'=>true,
	'changeYear'=>true,
	'showOn'=>'focus'
);
?>

<style type="text/css">
.filters {
	margin-bottom: 10px;
}
.filters .buttons {
	margin-top: 10px;
}
</style>

<script type="text/javascript">
function doFilter()
{
	$.fn.yiiGridView.update('grid-reports', {data: $('.filters :input').serialize()});
	return false;
}
function clearFilter()
{
	$('.filters input').val('');
	$.fn.yiiGridView.update('grid-reports', {data: $('.filters :input').serialize()});
	return false;
}
</script>

<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> */ ?>
<?php echo CHtml::form($this->createUrl('simple',array('csv'=>1)),'get'); ?>
<div class="filters">
	<fieldset><legend>Filters</legend>
		Date From:
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'date[from]',
			'options'=>$filterDatePickerOptions,
			'htmlOptions'=>array(
				'style'=>'width:80px'
			),  
		));
		?>
		Date To:
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'date[to]',
			'options'=>$filterDatePickerOptions,
			'htmlOptions'=>array(
				'style'=>'width:80px'
			),  
		));
		?>
		<div class="buttons">
			<?php echo CHtml::link('Filter', '#', array(
				'class'=>'button blue',
				'onclick'=>'return doFilter()'
			)); ?>
			<?php echo CHtml::link('Clear', '#', array(
				'class'=>'button',
				'onclick'=>'return clearFilter()'
			)); ?>
		</div>
	</fieldset>
</div>
<?php echo CHtml::linkButton('Save as CSV', array('class'=>'button green')); ?>
<?php echo CHtml::endForm(); ?>
<?php
$columns = array(
	/*array(
		'class'=>'ButtonColumn',
		'header'=>'Action',
		'template'=>'{delete}',
	),*/
	array(
		'header'=>'Model ID',
		'name'=>'model_id'
	),
	array(
		'header'=>'Model Name',
		'name'=>'model_fullname'
	),
	array(
		'header'=>'Model Email',
		'name'=>'model_email'
	),
	array(
		'header'=>'No. of Packages',
		'name'=>'packages_num',
		'footer'=>'<b>Total</b>: '.$totalPackages
	),
	array(
		'header'=>'No. of Clients',
		'name'=>'clients_num'
	)
);
$this->widget('ext.grid.GridView', array(
	'id'=>'grid-reports',
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
	'columns'=>$columns
));
?>