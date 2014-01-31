<?php
//$this->title = CHtml::encode($model->fullname);
Yii::app()->clientScript->registerCssFile($this->module->assetPath.'/css/front/view.css');
$cb = $this->widget('ext.colorbox.JColorBox');
$cb->addInstance('#modelnav-video a', array('innerWidth'=>$this->module->videosSize[0]+3,'innerHeight'=>$this->module->videosSize[1]+3));
//$cb->addInstance('#modelnav-minibooks a', array('inline'=>true));

$this->renderPartial('view/'.$model->agency->layout, array(
	'model' => $model,
	'galleryModule'=>$galleryModule,
	'gallery' => $gallery,
	'images' => $gallery->imagesPublic,
	'menu'=>$menu,
));
?>
<div class="clear"></div>
<div style="display: none">
	<div id="model-minibooks">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
		  <tr>
			<td class="td1"><?php echo CHtml::link('Minibook v.1', $this->createUrl('createMinibook', array('model_id'=>$model->id,'type'=>0)),array('target'=>'_blank')); ?></td>
		  </tr>
		  <tr>
			<td class="td1"><?php echo CHtml::link('Minibook v.2', $this->createUrl('createMinibook', array('model_id'=>$model->id,'type'=>1)),array('target'=>'_blank')); ?></td>
		  </tr>
		  <tr>
			<td class="td1"><?php echo CHtml::link('Minibook v.3', $this->createUrl('createMinibook', array('model_id'=>$model->id,'type'=>2)),array('target'=>'_blank')); ?></td>
		  </tr>
		</table>
	</div>
</div>
<?php foreach(array('polaroids'=>$polaroids,'covers'=>$covers) as $menu => $items): ?>
<?php
	if($items):
		$cb->addInstance("#model-{$menu} a", array('rel'=>'model-'.$menu));
		Yii::app()->clientScript->registerScript('click-model-'.$menu, "$('#modelnav-{$menu}').click(function(){\$('#model-{$menu} a:first').click()});");
?>
<div style="display: none">
	<div id="model-<?php echo $menu; ?>">
		<?php
		foreach($items->images as $img)
			echo CHtml::link('',$img->src['large'],array('rel'=>'model-'.$menu));
		?>
	</div>
</div>
<?php endif; ?>
<?php endforeach; ?>