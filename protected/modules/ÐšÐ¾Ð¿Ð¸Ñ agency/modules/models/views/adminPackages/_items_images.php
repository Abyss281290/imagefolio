<fieldset class="items gallery"><legend>Images</legend>
	<?php if($items = $model->getImagesItems($model_id)): ?>
	<ul>
		<?php
			foreach($items as $item):
				$image = $item->image;
		?>
		<li id="model-image-<?php echo $item->id; ?>">
			<?php echo CHtml::link(CHtml::image($image->src['small']),$image->src['large'],array('rel'=>'model-images')); ?>
			<ul class="img_options">
				<li class="delete"><?php echo CHtml::ajaxLink(
						'Delete',
						$this->createUrl('deleteItem',array('item_id'=>$item->id)),
						array(
							'success'=>'js:function(){
								$("#model-image-'.$item->id.'").remove();
							}'
						),
						array(
							'id'=>'mode-image-delete-'.$item->id,
							'confirm'=>'Delete image from package?',
							'onclick'=>'
								$(this).closest(".img_options").addClass("active");
								$(this).closest("li").addClass("loading");
							'
						)
				); ?></li>
			</ul>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php else: ?>
		Model has no images
	<?php endif; ?>
</fieldset>