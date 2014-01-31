<?php
//$this->title = $model->full_name;
?>
<div class="agencies-view">
	<?php /*<h5><?php echo $model->full_name; ?></h5>*/ ?>
	<div class="agency-content">
		<?php /*if($model->image): ?>
		<div class="agency-logo">
			<?php echo CHtml::image($model->image->full); ?>
		</div>
//		<?php endif; */ ?>
		<div class="agency-about wysiwyg-content"><?php echo $model->home_text; ?></div>
	</div>
</div>