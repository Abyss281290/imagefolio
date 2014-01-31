<?php
//$this->title = 'Models / '.CHtml::encode($type->title);

$galleryModule = Yii::app()->getModule('gallery');
//$this->widget('ext.colorbox.JColorBox')->addInstance('.models-list .items li a');
?>
<style type="text/css">
	.models-list .items li h4 {
		font-size: 14px !important;
	}
</style>
<?php if($models): ?>
<div class="models-list">
	<ul id="portfoliolist-1" class="items">
	<?php foreach($models as $item): ?>
		<li>
			<?php
			$image = CHtml::image($item->mainImage, '', array('class'=>'imgportfolio imgbox'));
			echo CHtml::link($image, $this->createUrl('view', array('id'=>$item->id)));
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