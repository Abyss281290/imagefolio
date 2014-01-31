<?php
$this->breadcrumbs=array(
	$model->agency->full_name=>array('/agency/agencies/default/view/','id'=>$model->agency->id),
	'Packages',
	$model->title
);
$this->title = CHtml::encode($model->title);
$this->pageTitle = array($model->title,'Packages',$model->agency->full_name);

$galleryModule = Yii::app()->getModule('gallery');
//$this->widget('ext.colorbox.JColorBox')->addInstance('.models-list .items li a');
?>
<?php if($models = $model->getModels()): ?>
<style type="text/css">
	.models-list h4 {
		font-size: 14px;
	}
</style>
<div class="models-list">
	<ul id="portfoliolist-1" class="items">
	<?php foreach($models as $item): ?>
		<li>
			<?php
			$image = CHtml::image($item->mainImage, '', array('class'=>'imgportfolio imgbox'));
			echo CHtml::link($image, $this->createUrl('model', array('package_hash'=>$model->hash,'model_id'=>$item->id)));
			//echo $imageBig? CHtml::link($image, $imageBig) : $image;
			?>
			<h4>
				<?php echo $imageBig? CHtml::link(CHtml::encode($item->fullname), $imageBig) : CHtml::encode($item->fullname); ?>
			</h4>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
<?php else: ?>
No models found
<?php endif; ?>