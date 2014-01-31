<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Contacts'
);
$this->title = 'Contacts';
?>
<?php echo CHtml::link('Create Contact', array('create'), array('class'=>'button blue','style'=>'margin-bottom:10px')); ?>
<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> */ ?>
<?php $this->widget('ext.grid.GridView', array(
	'id'=>'agency-companies-contacts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{update}&nbsp;&nbsp;{delete}',
		),
		'name',
		'email',
		'telephone',
		'telephone2',
		array(
			'name'=>'company_id',
			'filter'=>CompaniesHelper::getDropDownListData(),
			'value'=>'$data->company->name'
		),
		//'id',
		/*
		'position',
		'address',
		'comments',
		*/
	),
)); ?>
