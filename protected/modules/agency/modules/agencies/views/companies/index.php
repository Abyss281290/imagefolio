<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Clients',
);
$this->title = 'Clients';
?>
<?php echo CHtml::link('Create Client', array('create'), array('class'=>'button blue','style'=>'margin-bottom:10px')); ?>
<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> */ ?>
<?php $this->widget('ext.grid.GridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{contacts}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
			'buttons'=>array(
				'contacts'=>array(
					'label'=>'Contacts',
					'imageUrl'=>$this->module->assetPath.'/images/icon-contacts.png',
					'url'=>'Yii::app()->createUrl("/agency/agencies/companiesContacts/index",array("company_id"=>$data->id))'
				)
			)
		),
		//'agency_id',
		'name',
		'category',
		'email',
		'address',
		'telephone',
		//'comments',
		//'id',
	),
)); ?>