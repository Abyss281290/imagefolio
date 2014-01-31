<?php
$this->widget('ext.colorbox.JColorBox')->addInstance('.models-tile .item .image a');
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
</style>
<div class="models-tile">
	<?php echo CHtml::link('Create Model', array('admin/create'), array('class'=>'button blue', 'style'=>'margin-bottom:10px')); ?>
	<div id="models-grid" class="grid-view">
		<?php
		$grid = $this->widget('application.modules.agency.modules.models.extensions.ModelsTileGridView', array(
			'id'=>'models-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'filterLetters'=>array(
				'title'=>'Please select char to filter by Last name'
			),
			'template'=>'{summary}<div class="filters">{filterLetters}{filter}</div>',
			'columns'=>array(
				'fullname',
				'email',
				'telephone',
				array(
					'name' => 'type_id',
					'header' => 'Types',
					'filter'=>CHtml::listData(AgencyTypes::model()->findAll('active=1'), 'id', 'title')
				),
				'id'
			),
		));
		?>
		<div class="items">
			<?php
			//$i=0;
			foreach($model->search()->getData() as $m):
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
					$imageBig = $mainGalleryImage->src[$sizeBig];
				} else {
					if($gallery->images) {
						$image = $gallery->images[0]->src[$size];
						$imageBig = $gallery->images[0]->src[$sizeBig];
					} else {
						$image = $galleryModule->noImage;
						$imageBig = false;
					}
				}
			?>
				<div class="item">
					<?php //if($i%14==0) echo '</tr><tr>' ?>
					<div class="image">
						<?php
						$image = CHtml::image($image);
						echo $imageBig? CHtml::link($image, $imageBig, array('title'=>$m->fullname)) : $image;
						?>
					</div>
					<?php /*<div class="name"><?php echo $m->fullname; ?></div>*/ ?>
					<div class="actions">
						<?php echo CHtml::link(CHtml::image($this->module->assetPath.'/images/update.png'), $this->createUrl('update',array('id'=>$m->id))); ?>
						<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/gallery.png'), $galleryModule->getAdminRoute("models", $m->id, "/agency/models/admin/index")); ?>
						<?php echo CHtml::link(CHtml::image($this->module->assetPath.'/images/calendar.png'), '#'); ?>
						<div class="clear"></div>
					</div>
					<div class="status"><?php echo CHtml::image($this->module->assetPath.'/images/p.gif'); ?></div>
					<div class="select"><?php echo CHtml::checkBox("model[]",false,array('value'=>$m->id)); ?></div>
					<div class="id">#&nbsp;<?php echo $m->id; ?></div>
				</div>
			<?php
				//$i++;
			endforeach;
			?>
		</div>
	</div>
</div>