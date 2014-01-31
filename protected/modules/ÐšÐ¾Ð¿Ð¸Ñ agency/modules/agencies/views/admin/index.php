<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Agencies'=>array('/agency/agencies/admin/index'),
	'Manage',
);

$this->title = 'Manage Agencies';
?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<?php echo CHtml::link('Create Agency', array('admin/create')); ?>

<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
));*/ ?>
</div><!-- search-form -->

<?php
Yii::import('ext.geo.GeoHelper');

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
	'id'=>'content-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			'template'=>'{menus}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{active}{unactive}',
			'buttons'=>array(
				'active'=>array(
                    'label'=> Yii::t('main', 'Change Status'),
                    'url'=>'Yii::app()->controller->createUrl("changeActivity", array("id"=>$data->id))',
                    'imageUrl' => Yii::app()->baseUrl . "/". Yii::app()->params["imageStatusOn"],
					'click' => $JSClick,
					'visible'=>'$data->active',
                ),
				'unactive'=>array(
                    'label'=> Yii::t('main', 'Change Status'),
                    'url'=>'Yii::app()->controller->createUrl("changeActivity", array("id"=>$data->id))',
                    'imageUrl' => Yii::app()->baseUrl . "/". Yii::app()->params["imageStatusOff"],
					'click' => $JSClick,
					'visible'=>'!$data->active',
                ),
				'menus'=>array(
                    'label'=> 'Menu',
                    'url'=>'Yii::app()->controller->createUrl("menus/index", array("agency_id"=>$data->id))',
                    'imageUrl' => $this->module->assetPath.'/images/icon-menu.png',
                ),
			)
		),
		'full_name',
		'owner_name',
		array(
			'header'=>'Country',
			'type'=>'raw',
			'value'=>'
				GeoHelper::getSingleValue("countries", $data->country_id);
			',
		),
		array(
			'header'=>'City',
			'type'=>'raw',
			'value'=>'
				GeoHelper::getSingleValue("cities", $data->city_id);
			',
		),
		'id',
		array(
			'header'=>'Models',
			'type'=>'raw',
			'value'=>'
				CHtml::link(
					CHtml::image("'.$this->module->getParentModule()->assetPath.'/images/models.png")."&nbsp;$data->models_count",
					Yii::app()->createUrl("'.$this->module->getParentModule()->id.'/models/admin/index", array("agency_id"=>$data->id)),
					array("class"=>"button small nowrap")
				)
			',
		),
	),
)); ?>