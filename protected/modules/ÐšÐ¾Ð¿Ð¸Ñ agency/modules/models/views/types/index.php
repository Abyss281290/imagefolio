<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Types',
);

$this->title = 'Agency Types';
?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<?php echo CHtml::link('Create Type', array('create')); ?>

<?php
$JSClick = 'function() {
	url = this.href;
	img = $(this).children("img");
	img.attr("src", "'.Yii::app()->baseUrl . '/'. Yii::app()->params['ajaxLoader'].'");
	$.post(url, function(data){
		img.attr("src", data);
	},
	"html");
	return false;
}';

$this->widget('ext.grid.GridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{update} {delete} {active}{unactive}',
            'buttons'=>array(
				'active'=>array(
                    'label'=> Yii::t('main', 'Change Status'),
                    'url'=>'Yii::app()->createUrl("agency/models/types/changeActivity", array("id"=>$data->id))',
                    'imageUrl' => Yii::app()->baseUrl . "/". Yii::app()->params["imageStatusOn"],
					'click' => $JSClick,
					'visible'=>'$data->active',
                ),
				'unactive'=>array(
                    'label'=> Yii::t('main', 'Change Status'),
                    'url'=>'Yii::app()->createUrl("agency/models/types/changeActivity", array("id"=>$data->id))',
                    'imageUrl' => Yii::app()->baseUrl . "/". Yii::app()->params["imageStatusOff"],
					'click' => $JSClick,
					'visible'=>'!$data->active',
                ),
			),
		),
		'title',
		'description',
		'id'
	),
)); ?>