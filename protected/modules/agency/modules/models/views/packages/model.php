<?php
$this->breadcrumbs=array(
	$package->agency->full_name=>array('/agency/agencies/default/view/','id'=>$package->agency->id),
	'Packages',
	$package->title => array('view','hash'=>$package->hash),
	$model->fullname
);
//$this->title = CHtml::encode($model->fullname);
$this->pageTitle = array($model->fullname,$package->title,'Packages',$package->agency->full_name);

Yii::app()->clientScript->registerCssFile($this->module->assetPath.'/css/front/package-model.css');

Yii::app()->clientScript->registerCssFile($this->module->assetPath.'/css/front/view.css');

foreach($items as $k=>$item)
	$items[$k] = $item->image;
$this->renderPartial('/default/view/'.$model->agency->layout, array(
	'model' => $model,
	//'characteristics' => $model->characteristics,
	'galleryModule'=>$galleryModule,
	'gallery' => $gallery,
	'images'=>$items,
	'menu'=>$menu,
));
return;
$this->widget('ext.colorbox.JColorBox')->addInstance('#model-images li a');
?>
<?php if($items): ?>
<ul id="model-images">
	<?php
		foreach($items as $item):
			$image = $item->image;
	?>
	<li id="<?php echo $item->id; ?>">
		<?php echo CHtml::link(CHtml::image($image->src['medium']),$image->src['large'],array('rel'=>'model-images')); ?>
	</li>
	<?php endforeach; ?>
</ul>
<?php else: ?>
	Model has no images
<?php endif; ?>