<?php
$this->title = 'Gallery';

$this->breadcrumbs=$model->options['breadcrumbs'];

$returnButton = CHtml::link(
	$model->options['breadcrumbs']? 'Finish' : 'Return',
	$this->createUrl($model->returnUrl),
	array('class' => 'button')
);

$fieldsNum = min($this->module->imagesLimitPerGallery, $model->agencyModel->agency->plan->images_allowed-count($model->images));
?>
<div class="admin-image-gallery">
	<div class="row buttons" style="margin-bottom: 10px">
		<?php echo $returnButton; ?>
		<?php 
		
		if($model->images): ?>
			<?php
			
			
			$gallerycode = @intval($_REQUEST["gallerycode"]);
			switch($gallerycode)	{
				case 0: 
				default:
					$link = "Gallery";
					break;
				/*case 1:
					$link = "Polaroids";
					break;
				case 2:
					$link = "Covers";
					break;*/
				
			}
			//$mpdf->output();
			?>
			<?php
			echo CHtml::link(
						"Download minibook - ver. 1",
						ModelsHelper::getMinibookUrl($model->agencyModel, 0),
						array('type'=>'GET','target'=>'_blank')
						
					)." &nbsp;";
			/*echo CHtml::link(
						"Download minibook - ver. 2",
						$this->createUrl('/agency/models/admin/createMinibook',array('model_id'=>$model->item_id, 'type'=>'1')),
						array('type'=>'GET','target'=>'_blank')
						
					)." &nbsp;";
			echo CHtml::link(
						"Download minibook - ver. 3",
						$this->createUrl('/agency/models/admin/createMinibook',array('model_id'=>$model->item_id,'type'=>'2')),
						array('type'=>'GET','target'=>'_blank')
						
					);*/
				?>
			
			<!--">Download minibook</a> -->
		<?php endif; ?>
	</div>
	<fieldset class="images gallery"><legend>Gallery (<?php echo count($model->images); ?> / <?php echo $model->agencyModel->agency->plan->images_allowed; ?>)</legend>
		<ul class="notations">
			<li class="main"><span></span> - Main image</li>
			<li class="public"><span></span> - Public image</li>
		</ul>
		<div class="clear"></div>
		<?php if($model->images): ?>
		<?php
			$images = array();
			$sizes = $module->getSizes();
			$width = $sizes[$module->backendThumbsSize][0];
			$height = $sizes[$module->backendThumbsSize][1];
			foreach($model->images as $item) {
				$class = "item";
				if($item->main)
					$class .= " main";
				if($item->public)
					$class .= " public";
				$buttons = array();
				$buttons[] = '<li class="public">'.CHtml::link('Publish image', '#', array('title'=>'Publish image','onclick'=>'return Gallery.publishImage(this, "'.$item->id.'")')).'</li>';
				$buttons[] = '<li class="main">'.CHtml::link('Set as main image', '#', array('title'=>'Set as main image','onclick'=>'return Gallery.setMain(this, "'.$item->id.'")')).'</li>';
				//$buttons[] = '<li class="edit">'.CHtml::link('Edit', '#', array('onclick'=>'return Gallery.viewCrop(this, "'.$item->id.'")')).'</li>';
				$buttons[] = '<li class="delete">'.CHtml::link('Delete', '#', array('title'=>'Delete','confirm' => 'Delete image?', 'onclick'=>'return Gallery.remove(this, "'.$item->id.'")')).'</li>';
				$img = '<div class="'.$class.'" id="gallery_image_'.$item->id.'">'.CHtml::link(CHtml::image($item->src[$module->backendThumbsSize],'',array('width'=>$width,'height'=>$height)), $item->src['large'], array('target'=>'_blank', 'rel'=>'admin-image-gallery', 'class'=>'image'))
	.CHtml::hiddenField('gallery-image', $item->id)
	.'<ul class="img_options">'.implode('',$buttons).'</ul></div>';
				$img .= CHtml::tag('div',array('class'=>'checkbox'),CHtml::checkBox('gallery-image-checkbox',false,array('value'=>$item->id)));
				$images[] = $img;/*'<li class="delete">'.CHtml::link('Delete', '#', array('onclick'=>"if(confirm('Delete image?')) Gallery.remove(this, '{$item->id}'); return false")).'</li>';*/
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
	<fieldset class="upload"><legend>Upload (<?php echo $fieldsNum;//$imagesLeft = $this->module->imagesLimitPerGallery - count($model->images); 	//commenting it for now 	?>)</legend>
		<div id="upload_container"<?php if(!$fieldsNum) echo ' style="display:none"'; ?>>
			<ul class="files" id="files">
			<?php for($i=0; $i<$fieldsNum; $i++): ?>
				<li>
					<?php echo CHtml::beginForm($this->createUrl('uploadTemp'), 'post', array(
						'enctype' => 'multipart/form-data',
					)); ?>
					<?php echo CHtml::fileField('file', '', array(
						'onchange' => 'Gallery.fileFieldOnChange('.$i.')',
						'id' => 'file_'.$i
					)); ?>
					<?php echo CHtml::endForm(); ?>
				</li>
			<?php endfor; ?>
			</ul>
			
			<?php $form = $this->beginWidget('CActiveForm', array(
				'action' => $this->createUrl('upload'),
				'id'=>'gallery-upload-form',
				'enableAjaxValidation'=>false,
				'htmlOptions' => array(
					'enctype' => 'multipart/form-data',
					'onsubmit' => 'return Gallery.onStartUpload()'
				),
			)); ?>
			<?php echo CHtml::hiddenField('scope', $model->scope); ?>
			<?php echo CHtml::hiddenField('item_id', $model->item_id); ?>
			<?php echo CHtml::hiddenField('gallerycode', $model->gallerycode); ?>
			<?php echo CHtml::hiddenField('returnUrl', $model->returnUrl); ?>
			<div id="uploaded_files"></div>
			<div class="row buttons" style="margin-top: 10px">
				<?php echo CHtml::submitButton('Upload', array('class' => 'button blue submit')); ?>
				<div class="loader"></div>
			</div>
			<?php $this->endWidget(); ?>
		</div>
	<?php  if(!$fieldsNum): ?>
	<div id="upload-limit-error">
		You reached the image uploading limit (Max: <?php echo $model->agencyModel->agency->plan->images_allowed; ?>)
	</div>
	<?php  endif; ?>
	</fieldset>
</div>

<div class="row buttons" style="margin-top: 10px">
	<?php echo $returnButton; ?>
</div>