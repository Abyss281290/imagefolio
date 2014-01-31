<?php
$image = $gallery? $gallery->getMainImage('large', false, $gallery->imagesPublic) : $galleryModule->noImage;
//$this->widget('ext.colorbox.JColorBox')->addInstance('.model_gallery a', array('rel'=>'model_gallery'));
?>
<div class="model tile">

	<div id="model_photo_container">
		<?php echo CHtml::image($image, '', array('class'=>'model_photo')); ?>
	</div>
	<div class="model_info">
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

	<?php if($menu): ?>
	<ul class="modelnav">
		<?php foreach($menu as $id=>$item): ?>
		<li id="modelnav-<?php echo $id; ?>">
			<?php echo $item[3]? '<span>'.$item[0].'</span>' : CHtml::link($item[0], $item[1], $item[2]); ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	</div>

	<div class="model_gallery">
		<a href="#" class="nav prev">Prev</a>
		<div class="items">
			<?php //echo $this->viewTileLoadImages($gallery->id, 0, 9); ?>
		</div>
		<a href="#" class="nav next">Next</a>
	</div>
	
</div>
<script type="text/javascript">
<?php
$tmp = array();

	if($images) {
		foreach($images as $image) {
			$tmp[] = array($image->src['medium'], $image->src['large']);
		}
	}


?>
var images = <?php echo CJSON::encode($tmp); ?>;

var loadedImages = {};
$('.model_gallery a.image').live('click',function(){
	var newSrc = $(this).attr('href');
	var img = $('.model_photo');
	var showFx = function(img){
		img.stop().css({opacity:0}).animate({opacity:1},400);
	}
	if(!loadedImages[newSrc]) {
		$('<div class="loading"></div>')
			.css({
				width: img.width(),
				height: img.height()
			})
			.appendTo('#model_photo_container');
		img.css('visibility','hidden');
		img.load(function(){
			loadedImages[$(this).attr('src')] = 1;
			$('#model_photo_container .loading').remove();
			$(this).css({visibility: 'visible'});
			showFx($(this));
		});
	} else {
		showFx(img);
	}
	img.attr('src', newSrc);
	return false;
});

var imagesOffset = 0;
var imagesOffsetMax = <?php echo count($images); ?>;
var imagesLimit = 9;
function loadImages(offset)
{
	offset = offset < 0? 0 : (offset > imagesOffsetMax? imagesOffsetMax : offset);
	$('.model_gallery a.image').css({opacity:0.3});
	//var loading = $('<div class="loading"></div>');
	var items = $('.model_gallery .items');
	//items.css({width: items.width(), height: items.height()});
	//loading.css({width: items.width(), height: items.height()});
	//items.append(loading);
	
	items.text('');
	var slicedImages = images.slice(offset, offset+imagesLimit);
	for(var img, l=slicedImages.length, i=0; i<l; i++) {
		items.append(
			$('<a></a>')
				.attr('href', slicedImages[i][1])
				.attr('class', 'image')
				.append(
					$('<img />')
						.attr('src', slicedImages[i][0])
				)
		);
	}
	
	showNav(offset, slicedImages.length);
	
	/*$.ajax({
		type: 'GET',
		url: '<?php echo $this->createUrl('viewTileLoadImages'); ?>',
		data: {gallery_id: <?php echo (int)$gallery->id; ?>, offset: offset, limit: imagesLimit},
		success: function(html) {
			$('.model .model_gallery .items').html(html);
			imagesOffset = offset;
			items.removeClass('loading');
		}
	});*/
	return false;
}
function showNav(offset, imagesLength)
{
	var prev = $('.model_gallery a.nav.prev');
	var next = $('.model_gallery a.nav.next');

	if(offset <= 0)
		_showNavHide(prev, true);
	else
		_showNavHide(prev, false);
	offset += imagesLength;
	if(offset >= imagesOffsetMax || imagesOffsetMax <= imagesLimit)
		_showNavHide(next, true);
	else
		_showNavHide(next, false);
}
function _showNavHide(nav, hide)
{
	nav.css({visibility: hide || typeof hide == 'undefined'? 'hidden' : 'visible'});
}

//init
loadImages(0);
//$('.model_gallery a.image:first').click();
$('.model_gallery a.nav.prev').click(function(){ return loadImages(imagesOffset - imagesLimit) });
$('.model_gallery a.nav.next').click(function(){ return loadImages(imagesOffset + imagesLimit) });
showNav(0);
</script>

