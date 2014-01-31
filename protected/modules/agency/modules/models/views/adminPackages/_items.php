<?php
$this->widget('ext.colorbox.JColorBox');
$this->widget('zii.widgets.jui.CJuiSortable');
$this->widget('ext.tipsy.Tipsy', array(
	'fade' => false,
	'gravity' => 'n',
	'opacity'=>1,
	'items' => array(array('id'=>'.item .image a')),
));
?>
<style type="text/css">
.models-tile .items {
	width: auto;
	margin: 0 auto;
}
.models-tile .items .item {
	vertical-align: top;
	text-align: center;
	border: 1px solid #ccc;
	padding: 15px;
	line-height: normal;
	float: left;
	margin: 0 2px 2px 0;
}
.models-tile .items .item.active {
	background: #FAE8AF;
	border-color: #999;
}
.models-tile .items .item .name {
}
.models-tile .item .actions {
	margin-bottom: 5px;
}
.models-tile .item .actions a {
	float: left;
	margin-right: 2px;
	padding: 1px;
}
.models-tile .item .actions a:hover {
	background: #ccc;
}
.models-tile .item .actions .edit {
}
.models-tile .item .image {
	margin-bottom: 2px;
}
.models-tile .item .image img {
	width: 75px;
	height: 100px;
}
.models-tile .item .status,
.models-tile .item .select {
	float: left;
}
.models-tile .item .id {
	float: right;
	font-size: 10px;
}
.models-tile .filters {
	padding-bottom: 10px;
	margin-bottom: 10px;
	border-bottom: 1px solid #ddd;
}
.models-tile .grid-view .filters input,
.models-tile .grid-view .filters select {
	width: auto !important;
}
#models-package-images img.loader {
	margin: 10px;
}
</style>
<script type="text/javascript">
	function viewModelImages(package_id, model_id)
	{
		$('#models-package-images').html('<img src="<?php echo Yii::app()->baseUrl.'/'.Yii::app()->params['ajaxLoader']; ?>" class="loader">');
		$('.models-tile .items .item').removeClass('active');
		$('#model-item-'+model_id).addClass('active');
		jQuery.ajax({
			url: '<?php echo $this->createUrl('viewModelImages'); ?>',
			data: {package_id: package_id, model_id: model_id},
			type: 'get',
			success: function(html){
				jQuery('#models-package-images').html(html);
				initializePackage();
			}
		});
		return false;
	}
	
	function deleteImage(objButton, id)
	{
		if(confirm('Delete image from package?')) {
			$(objButton).closest(".img_options").addClass("active");
			$(objButton).closest("li").addClass("loading");
			$.ajax({
				url: $(objButton).attr('href'),
				cache: false,
				success: function(){
					$("#model-image-"+id).closest('li').hide(200,function(){$(this).remove()});
				}
			});
		}
		return false;
	}
	
	function initializePackage()
	{
		// colorbox
		jQuery('#models-package-images a[rel=model-images]').colorbox({rel:'model-images'});
		// sortable
		jQuery('ul#model-images').sortable({
			delay: '0',
			//revert: true,
			helper: 'clone',
			cursor: 'move',
			beforeStop: function(event, ui) {
			jQuery.ajax({
				data: {
					order: $("ul#model-images").sortable("toArray").toString()
				},
				url: '<?php echo $this->createUrl('orderItems',array('package_id'=>$model->id)); ?>',
				type: 'post',
				cache: false
			})
		}});
	}
	$(document).ready(initializePackage);
</script>
<?php if($models = $model->getModels()): ?>
<div class="models-tile" id="models-tile">
	<fieldset class="items gallery"><legend>Talents</legend>
		<ul>
			<?php
			$first_model_id = null;
			foreach($models as $m):
				$galleryModule = Yii::app()->getModule('gallery');
				$gallery = Gallery::model()->findByAttributes(array(
					'scope' => 'models',
					'item_id' => $m->id,
					'gallerycode' => 0
				));
				$galleryModule = Yii::app()->getModule('gallery');
				$gallery = Gallery::model()->findByAttributes(array('scope'=>'models','item_id'=>$m->id));
				$mainGalleryImage = GalleryImage::model()->findByAttributes(array('gallery_id'=>$gallery->id,'main'=>1));
				$size = 'small';
				$sizeBig = 'large';
				if($mainGalleryImage) {
					$image = $mainGalleryImage->src[$size];
					//$imageBig = $mainGalleryImage->src[$sizeBig];
				} else {
					if($gallery->images) {
						$image = $gallery->images[0]->src[$size];
						//$imageBig = $gallery->images[0]->src[$sizeBig];
					} else {
						$image = $galleryModule->noImage;
						//$imageBig = false;
					}
				}
				$onclick = 'return viewModelImages('.$model->id.', '.$m->id.')';
			?>
				<li class="item<?php if(!$first_model_id) echo ' active'; ?>" id="model-item-<?php echo $m->id; ?>">
					<?php //if($i%14==0) echo '</tr><tr>' ?>
					<div class="image">
						<?php
						$image = CHtml::image($image);
						echo CHtml::link(
							$image,
							'#',
							array(
								'title'=>$m->fullname,
								'onclick'=>$onclick
							)
						);
						?>
					</div>
					<div class="name"><?php echo CHtml::link(substr($m->firstname,0,10).'<br />'.substr($m->lastname,0,10), '#', array('onclick'=>$onclick)); ?></div>
					<div class="status"><?php echo CHtml::image($this->module->assetPath.'/images/p.gif'); ?></div>
					<div class="select"><?php echo CHtml::checkBox("model[]",false,array('value'=>$m->id)); ?></div>
					<div class="id">#&nbsp;<?php echo $m->id; ?></div>
					<ul class="img_options">
						<li class="delete"><?php echo CHtml::ajaxLink(
								'Delete',
								$this->createUrl('deleteModel',array('package_id'=>$model->id,'model_id'=>$m->id)),
								array(
									'success'=>'js:function(){
										$("#model-item-'.$m->id.'").remove();
										var model_id = $("#models-tile ul li:first").attr("id");
										if(model_id)
											viewModelImages('.$model->id.', model_id.replace("model-item-",""));
										else
											$("#models-package-images").html("");
									}'
								),
								array(
									'id'=>'mode-item-delete-'.$m->id,
									'confirm'=>'Delete talent from package?',
									'onclick'=>'
										$(this).closest(".img_options").addClass("active");
										$(this).closest("li").addClass("loading");
									'
								)
						); ?></li>
					</ul>
				</li>
			<?php
				if(!$first_model_id)
					$first_model_id = $m->id;
			endforeach;
			?>
		</ul>
	</fieldset>
</div>
<div id="models-package-images">
	<?php $this->renderPartial('_items_images',array('model'=>$model,'model_id'=>$first_model_id)); ?>
</div>
<?php endif; ?>