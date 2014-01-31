<?php
$model = ContentHelper::loadModel(2);
$this->title = $model->title;
?>
<div class="agency-terms wysiwyg-content">
	<?php echo $model->content; ?>
</div>