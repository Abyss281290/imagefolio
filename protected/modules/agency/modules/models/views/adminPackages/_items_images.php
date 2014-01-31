<fieldset class="items gallery"><legend>Images</legend>
	<?php if($items = $model->getImagesItems($model_id)): ?>
	<ul id="model-images">
		<?php
			foreach($items as $item):
				$image = $item->image;
		?>
		<li id="<?php echo $item->id; ?>">
			<div id="model-image-<?php echo $item->id; ?>">
				<?php echo CHtml::link(CHtml::image($image->src['small']),$image->src['large'],array('rel'=>'model-images')); ?>
				<ul class="img_options">
					<li class="delete"><?php echo CHtml::link('Delete', $this->createUrl('deleteItem',array('item_id'=>$item->id)),array('onclick'=>'return deleteImage(this,'.$item->id.')')); ?></li>
				</ul>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php else: ?>
		Model has no images
	<?php endif; ?>
</fieldset>