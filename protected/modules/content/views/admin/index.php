<?php
$this->breadcrumbs=array(
	$this->module->title
);

$this->title = 'Manage '.$this->module->title;
?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<?php //echo CHtml::link('Create '.$this->module->title, array('admin/create'), array('class'=>'button blue', 'style'=>'margin-bottom:10px')); ?>

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
	'id'=>'content-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'ButtonColumn',
            'header'=>'Action',
			//'template'=>'{gallery}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{active}{unactive}',
			'template'=>'{update}',
            'buttons'=>array(
               /* 'gallery'=>array(
                    'label' => 'Gallery',
					'imageUrl' => Yii::app()->request->baseUrl.'/images/gallery.png',
                    'url' => 'Yii::app()->getModule("gallery")->getAdminRoute("content", $data->id, "/content/admin/index")',
                ),
				'active'=>array(
                    'label'=> Yii::t('main', 'Change Status'),
                    'url'=>'Yii::app()->createUrl("content/admin/changeActivity", array("id"=>$data->id))',
                    'imageUrl' => Yii::app()->baseUrl . "/". Yii::app()->params["imageStatusOn"],
					'click' => $JSClick,
					'visible'=>'$data->active',
                ),
				'unactive'=>array(
                    'label'=> Yii::t('main', 'Change Status'),
                    'url'=>'Yii::app()->createUrl("content/admin/changeActivity", array("id"=>$data->id))',
                    'imageUrl' => Yii::app()->baseUrl . "/". Yii::app()->params["imageStatusOff"],
					'click' => $JSClick,
					'visible'=>'!$data->active',
                ),*/
			),
		),
		/*array(
			'type' => 'html',
			'value' => 'CHtml::image($data->image->fullPath, "", array("style"=>"width:100px"))'
		),*/
		//'created_time',
		'name',
		'title',
		/*array(
			'name' => 'category',
			'value' => '$data->category->title',
			'filter' => ContentHelper::getCategoriesIdTitle()
		),*/
		/*array(
			'name' => 'created_by',
			'header' => 'Author',
			'value' => '$data->created_by_obj->username'
		),*/
		//'id',
	),
)); ?>