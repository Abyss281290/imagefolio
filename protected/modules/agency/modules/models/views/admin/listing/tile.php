<?php
$this->widget('ext.colorbox.JColorBox');
$this->widget('ext.tipsy.Tipsy', array(
	'fade' => false,
	'gravity' => 'n',
	'opacity'=>1,
	'items' => array(array('id'=>'.item .image img')),
));
?>
<script type="text/javascript">
var f = function(){
	$('.models-tile .item .image a').colorbox({
		title: function(){ return $(this).find("img:first").attr("alt") }
	})
}
$(document).ajaxComplete(f);
$(f);
</script>
<style type="text/css">
	.models-tile .items {
		width: auto;
		margin: 0 auto;
	}
	.models-tile .items .item {
		vertical-align: top;
		text-align: center;
		border: 1px solid #ccc;
		padding: 4px 3px 3px 3px;
		line-height: normal;
		float: left;
		margin: 0 2px 2px 0;
		width: 78px; /* width with 20 chars in model name */
	}
	.models-tile .item .actions {
		margin-bottom: 5px;
	}
	.models-tile .item .actions a {
		float: left;
		margin-right: 1px;
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
	.models-tile .item .status {
		float: left;
	}
	.models-tile .item .id {
		float: right;
		font-size: 10px;
	}
	.models-tile .item .name {
		font-size: 10px;
		font-family: Verdana;
	}
	.models-tile .item .name.lastname {
		margin-bottom: 5px;
	}
	.models-tile .filters {
		padding-bottom: 10px;
		margin-bottom: 10px;
		border-bottom: 1px solid #ddd;
	}
	.models-tile .grid-view .filters input,
	.models-tile .grid-view .filters select {
		
	}
	.tipsy {
		font-family: Verdana;
	}
</style>
<div class="models-tile">
	<div id="models-grid" class="grid-view">
		<?php
		$columns = array(
			array(
				'name'=>'filter_fullname',
				'header'=>$model->getAttributeLabel('fullname'),
				'value'=>'$data->fullname'
			),
		);
		if(Yii::app()->user->isAdmin()) {
			$columns[] = array(
				'name'=>'agency_id',
				'filter'=>AgencyHelper::getAgenciesIdTitle()
			);
		}
		$columns[] = 'email';
		$columns[] = 'telephone';
		if(Yii::app()->user->isAgencyMember()) {
			$columns[] = array(
				'name' => 'type_id',
				'header' => 'Type',
				'filter'=>MenusHelper::getDropDownListTreeData(AgencyModule::getCurrentAgencyId())
			);
		} else {
			/*$columns[] = array(
				'name' => 'type_id',
				'header' => 'Type',
				'filter'=>CHtml::listData(AgencyTypes::model()->findAll('active=1'), 'id', 'title')
			);*/
		}
		
		//$columns[] = 'id';
		
		$grid = $this->widget('application.modules.agency.modules.models.extensions.ModelsTileGridView', array(
			'id'=>'models-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'filterLetters'=>array(
				'title'=>'Please select char to filter by First name or Last name'
			),
			'template'=>'{summary}<div class="filters">{filterLetters}{filter}</div>',
			'columns'=>$columns,
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
				//$m->firstname = str_repeat('x', 10);
				if($m->lastname === '')
					$m->lastname = '&nbsp;';
			?>
				<div class="item">
					<?php //if($i%14==0) echo '</tr><tr>' ?>
					<div class="image">
						<?php
						$image = CHtml::image($image, $m->fullname, array('title'=>$m->fullname));
						echo $imageBig? CHtml::link($image, $imageBig) : $image;
						?>
					</div>
					<div class="name firstname"><?php echo substr($m->firstname,0,10); ?></div>
					<div class="name lastname"><?php echo substr($m->lastname,0,10); ?></div>
					<div class="actions">
						<?php echo CHtml::link(CHtml::image($this->module->assetPath.'/images/update.png'), $this->createUrl('update',array('id'=>$m->id))); ?>
						<?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/gallery.png'), $galleryModule->getAdminRoute("models", $m->id, "/agency/models/admin/index")); ?>
						<?php echo CHtml::link(CHtml::image($this->module->assetPath.'/images/calendar.png'), '#'); ?>
						<?php echo CHtml::checkBox("model[]",false,array('value'=>$m->id)); ?>
						<div class="clear"></div>
					</div>
					<?php /* <div class="status"><?php echo CHtml::image($this->module->assetPath.'/images/p.gif'); ?></div> */ ?>
					<?php /*<div class="id">#&nbsp;<?php echo $m->id; ?></div>*/ ?>
				</div>
			<?php
				//$i++;
			endforeach;
			?>
		</div>
	</div>
</div>