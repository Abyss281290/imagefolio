<?php
$this->breadcrumbs=array(
	$this->module->id,
);
$this->title = $model->full_name;
?>
<div class="agencies-view">
	<h5><?php echo $item->full_name; ?></h5>
	<div class="agency-content">
		<?php if($model->image): ?>
		<div class="agency-logo">
			<?php echo CHtml::image($model->image->full); ?>
		</div>
		<?php endif; ?>
		<div class="agency-about"><?php echo $model->about; ?></div>
	</div>
</div>