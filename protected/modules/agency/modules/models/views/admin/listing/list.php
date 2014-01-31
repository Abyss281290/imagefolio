<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>

<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> */ ?>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

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

$columns = array(
	array(
		'class'=>'ButtonColumn',
		'header'=>'Action',
		'template'=>'{gallery} {video} {update} {delete} {active}{unactive}',
		'buttons'=>array(
			'update'=>array(
				'imageUrl'=>$this->module->assetPath.'/images/update.png'
			),
			'gallery'=>array(
				'label' => 'Gallery',
				'imageUrl' => Yii::app()->request->baseUrl.'/images/gallery.png',
				'url' => 'Yii::app()->getModule("gallery")->getAdminRoute("models", $data->id, "/agency/models/admin/index")',
			),
			'video'=>array(
				'label' => 'Video',
				'imageUrl' => Yii::app()->request->baseUrl.'/images/video.png',
				'url' => 'Yii::app()->createUrl("agency/models/admin/video", array("model_id"=>$data->id))',
			),
			'active'=>array(
				'label'=> Yii::t('main', 'Change Status'),
				'url'=>'Yii::app()->createUrl("agency/models/admin/changeActivity", array("id"=>$data->id))',
				'imageUrl' => Yii::app()->baseUrl . "/". Yii::app()->params["imageStatusOn"],
				'click' => $JSClick,
				'visible'=>'$data->active',
			),
			'unactive'=>array(
				'label'=> Yii::t('main', 'Change Status'),
				'url'=>'Yii::app()->createUrl("agency/models/admin/changeActivity", array("id"=>$data->id))',
				'imageUrl' => Yii::app()->baseUrl . "/". Yii::app()->params["imageStatusOff"],
				'click' => $JSClick,
				'visible'=>'!$data->active',
			),
		),
	),
	array(
		'class'=>'CCheckBoxColumn',
		'header'=>'Select',
		'htmlOptions'=>array('style'=>'text-align: center'),
		'name'=>'id',
		'selectableRows'=>2
	),
	/*array(
		'type' => 'html',
		'value' => 'CHtml::image($data->image->fullPath, "", array("style"=>"width:100px"))'
	),*/
	/*array(
		'header' => 'Select',
		'value' => 'CHtml::checkbox("model[]", null, array("value"=>$data->id))',
		'type' => 'raw',
		'htmlOptions'=>array('style'=>'text-align: center')
	),*/
	array(
		'name'=>'filter_fullname',
		'header'=>$model->getAttributeLabel('fullname'),
		'value'=>'$data->fullname'
	),
);
if(Yii::app()->user->isAdmin()) {
	$columns[] = array(
		'name'=>'agency_id',
		'type'=>'raw',
		'value'=>'
			$data->agency
				? Chtml::link($data->agency->full_name, Yii::app()->createUrl("/agency/agencies/admin/update",array("id"=>$data->agency->id)))
				: "- no agency -"
		',
		'filter'=>AgencyHelper::getAgenciesIdTitle()
	);
}
$columns[] = 'email';
$columns[] = 'telephone';
if(Yii::app()->user->isAgencyMember()) {
	$columns[] = array(
		'name' => 'type_id',
		'header' => 'Type',
		'value'=>'$data->type->title',
		'filter'=>MenusHelper::getDropDownListTreeData(AgencyModule::getCurrentAgencyId())
	);
} else {
	$columns[] = array(
		'name' => 'type_id',
		'header' => 'Type',
		'value'=>'$data->type->title',
		'filter'=>false,
		//'filter'=>CHtml::listData(AgencyTypes::model()->findAll('active=1'), 'id', 'title')
	);
}
//$columns[] = 'id';

$this->widget('ext.grid.GridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'filterLetters'=>array(
		'title'=>'Please select char to filter by First name or Last name'
	),
	'columns'=>$columns,
)); ?>