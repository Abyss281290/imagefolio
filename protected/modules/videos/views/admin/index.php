<?php
$this->title = 'Videos';

$this->breadcrumbs=array(
	$model->owner->title=>$this->createUrl($model->returnUrl),
	$model->owner->itemTitle,
	'Videos'
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
<fieldset class="upload form"><legend>Upload</legend>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action' => $this->createUrl('upload'),
		'id'=>'content-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation' => true,
		'clientOptions'=>array(
			'validateOnSubmit' => true,
			'validateOnChange' => true,
			'validateOnType' => false,
		),
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data'
		),
	)); ?>
	
	<?php echo CHtml::hiddenField('scope', $model->scope); ?>
	<?php echo CHtml::hiddenField('item_id', $model->item_id); ?>
	<?php echo CHtml::hiddenField('returnUrl', $model->returnUrl); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'video'); ?>
		<?php echo $form->fileField($model, 'video'); ?>
		<?php echo $form->error($model,'video'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model, 'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::label('',''); ?>
		<?php echo CHtml::submitButton('Upload', array('class' => 'button blue')); ?>
	</div>
	<?php $this->endWidget(); ?>
</fieldset>
<fieldset class="images gallery"><legend>Videos</legend>
	<?php if($model->videos_items): ?>
	<?php
		$images = array();
		$height = $module->thumbnailSize[1];
		foreach($model->videos_items as $item) {
			$images[] = CHtml::link(CHtml::image($item->image->thumbPath,'',array('height'=>$height)), $this->createUrl('viewVideoItem', array('id' => $item->id)), array('target'=>'_blank', 'rel'=>'admin-image-gallery', 'class'=>'image'))
.CHtml::hiddenField('gallery-image', $item->id)
.'<ul class="img_options">
	<li class="edit">'.CHtml::ajaxLink('Edit', '#', array()).'</li>
	<li class="delete">'.CHtml::ajaxLink('Delete', $this->createUrl('remove'), array(
		'data'=>'id='.$item->id,
		'context'=>'js:$(this)',
		'success'=>"js:function(){ $(this).parent().parent().parent().fadeOut(150,function(){ $(this).remove() }) }",
	), array("confirm"=>"Delete video?")).'</li>
</ul>
';
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
	$('.admin-image-gallery .images ul .image').colorbox({
		rel:'admin-image-gallery',
		innerWidth:<?php echo $module->videoSize[0] ?>,
		innerHeight:<?php echo $module->videoSize[1] ?>,
		iframe: true,
		fastIframe: false,
		current: 'video {current} of {total}'
	});
	</script>
<?php else: ?>
	<div class="empty">No videos uploaded</div>
<?php endif; ?>
</fieldset>
</div>

<div style="clear: left"></div>

<div class="row buttons" style="margin-top: 10px">
	<?php echo $returnButton; ?>
</div>