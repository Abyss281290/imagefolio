<?php
$this->title = 'Gallery';

$this->breadcrumbs=array(
	$model->owner->title=>$this->createUrl($model->returnUrl),
	$model->owner->itemTitle,
	'Gallery'
);

$returnButton = CHtml::link(
	$model->owner->exists? 'Finish (return to '.$model->owner->title.')' : 'Return',
	$this->createUrl($model->returnUrl),
	array('class' => 'button')
);
?>
<div class="admin-image-gallery">
	<div class="row buttons" style="margin-bottom: 10px">
		<?php echo $returnButton; ?>
	</div>
	<fieldset class="upload"><legend>Upload</legend>
		<?php $form = $this->beginWidget('CActiveForm', array(
			'action' => $this->createUrl('upload'),
			'id'=>'gallery-upload-form',
			'enableAjaxValidation'=>false,
			'htmlOptions' => array(
				'enctype' => 'multipart/form-data',
				'onsubmit' => 'return Gallery.onStartUpload()'
			),
		)); ?>
		<?php echo $form->errorSummary($model); ?>

		<?php echo CHtml::hiddenField('scope', $model->scope); ?>
		<?php echo CHtml::hiddenField('item_id', $model->item_id); ?>
		<?php echo CHtml::hiddenField('returnUrl', $model->returnUrl); ?>

		<?php
		$uploadify = $this->widget('ext.uploadify.uploadifyWidget', array(
			'jsOptions'=> array(
				'onAllComplete' => "js:function()
				{
					$('#gallery-upload-form').submit();
				}",
				'onSelectOnce' => "js:function()
				{
					$('#uploadify_box').fadeIn(700);
				}",
			)
		));
		echo $uploadify->button();
		?>
		<div id="uploadify_box" style="display:none">
			<?php echo $uploadify->queue(); ?>
			<div class="row buttons">
				<?php echo CHtml::submitButton('Upload', array('class' => 'button blue submit', 'onclick' => '$("#uploadify").uploadifyUpload(); Gallery.onStartUpload(); return false')); ?>
				<div class="loader"></div>
			</div>
		</div>

		<?php /*$this->widget('CMultiFileUpload', array(
			'name' => 'images',
			'accept' => 'jpeg|jpg|gif|png',
			'duplicate' => 'Duplicate file!',
			'denied' => 'Invalid file type',
		));*/ ?>
		<?php $this->endWidget(); ?>
	</fieldset>
	<fieldset class="images gallery"><legend>Gallery</legend>
		<?php if($model->images): ?>
		<?php
			$images = array();
			$sizes = $module->getSizes();
			$height = $sizes[$module->backendThumbsSize][1];
			foreach($model->images as $item) {
				$images[] = '<div class="item" id="gallery_image_'.$item->id.'">'.CHtml::link(CHtml::image($item->src[$module->backendThumbsSize],'',array('height'=>$height)), $item->src['large'], array('target'=>'_blank', 'rel'=>'admin-image-gallery', 'class'=>'image'))
	.CHtml::hiddenField('gallery-image', $item->id)
	.'<ul class="img_options">
		<li class="edit">'.CHtml::link('Edit', '#', array('onclick'=>'return Gallery.viewCrop(this, "'.$item->id.'")')).'</li>
		<li class="delete">'.CHtml::link('Delete', '#', array('confirm' => 'Delete image?', 'onclick'=>'return Gallery.remove(this, "'.$item->id.'")')).'</li>
	</ul></div>';/*'<li class="delete">'.CHtml::link('Delete', '#', array('onclick'=>"if(confirm('Delete image?')) Gallery.remove(this, '{$item->id}'); return false")).'</li>';*/
			}

			$this->beginWidget('zii.widgets.jui.CJuiSortable', array(
				//'tagName' => 'ul',
				'items' => $images,
				// additional javascript options for the accordion plugin
				'options' => array(
					'delay' => '0',
					'revert' => true,
					'helper' => 'clone',
					'cursor' => 'move',
					'beforeStop' => "js:function(event, ui) {
						jQuery.ajax({'data':
							{
								id: ui.item.find('input[name=\"gallery-image\"]').val(),
								order: parseInt(ui.helper.parent().children().index(ui.item))+1
							}
						,'url':'".$this->createUrl('ordering')."','cache':false})
					}"
				),
			));
		?>
		<?php $this->endWidget(); ?>
		<script type="text/javascript">
		$('.admin-image-gallery .images ul .image').colorbox({rel:'admin-image-gallery'});
		</script>
	<?php else: ?>
		<div class="empty">No images uploaded</div>
	<?php endif; ?>
	</fieldset>
</div>

<div class="row buttons" style="margin-top: 10px">
	<?php echo $returnButton; ?>
</div>