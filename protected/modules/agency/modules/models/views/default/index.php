<?php
Yii::app()->clientScript->registerCssFile($this->module->assetPath.'/css/front/index.css');
//$this->title = 'Models / '.CHtml::encode($type->title);
$galleryModule = Yii::app()->getModule('gallery');
//$this->widget('ext.colorbox.JColorBox')->addInstance('.models-list .items li a');
?>
<style type="text/css">
	.models-list .items li h4 {
		font-size: 14px !important;
	}
</style>
<div id="models-grid" class="models-list grid-view">
	<?php
	$dataProvider = $model->searchFront();
	$grid = $this->widget('application.modules.agency.modules.models.extensions.ModelsTileGridView', array(
		'id'=>'models-grid',
		'dataProvider'=>$dataProvider,
		'filter'=>$model,
		'filterLetters'=>array(
			'title'=>false
		),
		'template'=>'<div class="filters">{filterLetters}</div>',
		'columns'=>false,
		'ajaxUpdate'=>false
	));
	?>
	<ul id="portfoliolist-1" class="items">
		<?php foreach($dataProvider->getData() as $data): ?>
		<?php $this->renderPartial('index_model',array('data'=>$data)); ?>
		<?php endforeach; ?>
	</ul>
</div>