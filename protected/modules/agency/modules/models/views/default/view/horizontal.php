<?php
Yii::app()->clientScript->registerCssFile($this->module->assetPath.'/css/front/view-horizontal.css');
$image = $gallery? $gallery->getMainImage('large', false, $gallery->imagesPublic) : $galleryModule->noImage;
//$this->widget('ext.colorbox.JColorBox')->addInstance('.model_gallery_2 a', array('rel'=>'model_gallery'));
?>
<div class="model horizontal">
	
	<div class="display">
		<a href="#" class="nav prev">Prev</a>
		<div class="model_info_2">
			<h4><?php echo CHtml::encode($model->fullname); ?></h4>

			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabl">
			<?php if($characteristics = $model->characteristicsTitleValue): ?>
					<?php foreach($characteristics as $c): ?>
					<tr>
						<td class="td1"><?php echo CHtml::encode($c['title']); ?></td>
						<td class="td2"><?php echo $c['value']; ?></td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</table>
		</div>
		<?php echo CHtml::image($image, '', array('class'=>'model_photo')); ?>
		<a href="#" class="nav next">Next</a>
	</div>
	
	<div class="clear"></div>
	
	<div class="model_info_4">
		<?php if($menu): ?>
		<ul class="modelnav_2">
			<?php foreach($menu as $id=>$item): ?>
			<li id="modelnav-<?php echo $id; ?>">
				<?php echo $item[3]? '<span>'.$item[0].'</span>' : CHtml::link($item[0], $item[1], $item[2]); ?>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>


	<div class="model_gallery_2">
		<?php
		$this->widget('ext.JCarousel.JCarousel', array(
			'dataProvider' => new CArrayDataProvider(
				array_merge(
					array((object)array('src'=>array('medium'=>$this->module->assetPath.'/images/models-view-info.png','large'=>'#'))),
					$images
				),array('pagination'=>false)),
			'thumbUrl' => '$data->src["medium"]',
			'imageUrl' => '$data->src["large"]',
			'target' => '#123',
			//'animation'=>0
			//'htmlOptions'=>array('rel'=>'ads')
		));
		?>
		<?php
		/*if($gallery->images) {
			$i=0;
			foreach($gallery->images as $image) {
				$i++;
				echo CHtml::link(
					CHtml::image($image->src['medium'], '', array('rel'=>'model_gallery')),
					$image->src['large']
				);
			}
		}*/
		?>
		<div class="clear"></div>


	</div>
	
</div>
<script type="text/javascript">
var currentGroup = 0;
var maxGroup = 0;
var i=0;
var imagesCount = $('.model_gallery_2 ul a').length;
$('.model_gallery_2 ul a').each(function(k,v){
	$(v).attr('rel','group-'+i);
	if(k%2)
		maxGroup = i++;
});
maxGroup = parseInt(imagesCount/2);
$('.model_gallery_2 ul a').click(function(){
	var container = $(this).closest('.model');
	var model_photo = container.find('.model_photo');
	var model_photo2;
	if(!(model_photo2 = container.find('.model_photo2')).length) {
		model_photo2 = $('<img class="model_photo2">');
		model_photo.before(model_photo2);
	}
	var group = $(this).attr('rel').replace('group-','')*1;
	var objs = $(this).closest('ul').find('li a[rel='+$(this).attr('rel')+']');
	var obj = $(objs[0]);
	var obj2 = $(objs[1]);
	var src = obj2.attr('href');
	var src2 = obj.attr('href');
	
	// preload next images
	preloadGroupLargeImages(group+1);
	
	// fx
	if(group != currentGroup) {
		var display = $('.model .display');
		var displayClone = $('<div class="model model-fx"></div>').append(display.clone());
		displayClone.find('a.nav').css('visibility','hidden');
		displayClone.css({
			position: 'absolute',
			left: $('.model').position().left,
			top: $('.model').position().top,
			opacity: 1
		});
		//$('body').append(displayClone);
		displayClone.animate({'opacity':0,'margin-left':(group>currentGroup?-100:100)},400,function(){ $(this).remove(); });
	}
	
	if(group == 0) {
		// if first item (info)
		model_photo.attr('src', src);
		container.find('.model_info_2').show(0);
		model_photo2.hide(0);
		model_photo.show();
		// hide prev nav
		displayNavHideArrow('prev');
		displayNavHideArrow('next', false);
	} else {
		model_photo.attr('src', src);
		model_photo2.attr('src', src2);
		container.find('.model_info_2').hide(0);
		model_photo2.show(0);
		if(!src)
			model_photo.hide(0);
		else
			model_photo.show(0);
		// show prev nav
		displayNavHideArrow('prev', false);
		// hide next nav
		if(group >= maxGroup)
			displayNavHideArrow('next');
		else
			displayNavHideArrow('next', false);
	}
	currentGroup = group;
	return false;
});

function preloadGroupLargeImages(groupIndex)
{
	var groupItems = $('.model .model_gallery_2 li a[rel=group-'+(groupIndex)+']');
	if(groupItems.length) {
		groupItems.each(function(k,v){
			$('<img/>').attr('src',$(v).attr('href'));
		});
	}
}

function displayNav(modifier)
{
	//alert(currentGroup+modifier);
	$('.model .model_gallery_2 ul').find('li a[rel=group-'+(currentGroup+modifier)+']:first').click();
	return false;
}

function displayNavHideArrow(arrowClass, hide)
{
	$('.model:not(.model-fx) .display a.nav.'+arrowClass).css('visibility', hide||typeof hide == 'undefined'?'hidden':'visible');
}

// init
$('.model_photo, .model_photo2, .model .display a.nav.next').live('click',function(event){
	event.preventDefault();
	return displayNav(1);
});
$('.model .display a.nav.prev').click(function(event){
	event.preventDefault();
	return displayNav(-1);
});
$('.model_gallery_2 ul li a:first').click();
preloadGroupLargeImages(1);
displayNavHideArrow('prev');
</script>