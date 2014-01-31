<?php
$this->breadcrumbs=array(
	$this->module->id,
);

$this->title = 'Models / '.CHtml::encode($type->title);

$galleryModule = Yii::app()->getModule('gallery');
//$this->widget('ext.colorbox.JColorBox')->addInstance('.models-list .items li a');
?>
<?php if($models): ?>
<div class="models-list">
	<ul id="portfoliolist-1" class="items">
	<?php
		foreach($models as $item):
			$gallery = Gallery::model()->findByAttributes(array(
				'scope' => 'models',
				'item_id' => $item->id
			));
			$image = $gallery? $gallery->getMainImage('medium') : $galleryModule->noImage;
			//$imageBig = $gallery? $gallery->getMainImage('large', true) : false;
	?>
		<li>
			<h4>
				<?php echo $imageBig? CHtml::link(CHtml::encode($item->fullname), $imageBig) : CHtml::encode($item->fullname); ?>
			</h4>
			<?php
			$image = CHtml::image($image, '', array('class'=>'imgportfolio imgbox'));
			echo CHtml::link($image, $this->createUrl('view', array('id'=>$item->id)));
			//echo $imageBig? CHtml::link($image, $imageBig) : $image;
			?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
<?php else: ?>
No models found
<?php endif; ?>