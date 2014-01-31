<?php
?>
<?php if($gallery && count($gallery->images)): ?>
<div class="gallery-widget">
	<div id="slideshow-main">
		<ul>
			<?php foreach($gallery->images as $i => $img): ?>
			<li class="p<?php echo $i; ?>">
				<a href="#">
					<?php echo CHtml::image($img->src['large']); ?>
					<?php /*<span class="opacity"></span>
					 * <span class="content"><h1>Title 1</h1><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</p></span>*/ ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>										
	</div>

	<div id="slideshow-carousel">				
		  <ul id="carousel" class="jcarousel jcarousel-skin-tango">
			<?php foreach($gallery->images as $i => $img): ?>
			<li><a href="#" rel="p<?php echo $i; ?>"><?php echo CHtml::image($img->src['medium'],'',array('class'=>'sgallery')); ?></a></li>
			<?php endforeach; ?>
		  </ul>
	</div>
	
	<div class="clear"></div>
</div>
<?php endif; ?>