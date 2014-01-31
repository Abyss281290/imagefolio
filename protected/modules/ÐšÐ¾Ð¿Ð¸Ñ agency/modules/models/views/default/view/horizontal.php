<?php
$image = $gallery? $gallery->getMainImage('large') : $galleryModule->noImage;
$this->widget('ext.colorbox.JColorBox')->addInstance('.model_gallery_2 a', array('rel'=>'model_gallery'));
?>
<div class="model">

<div class="model_info_2">
<h4><?php echo CHtml::encode($model->fullname); ?></h4>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabl">
<?php if($characteristics): ?>
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

<div class="clear"></div>  

<div class="model_info_4">
	<?php if($menu): ?>
	<ul class="modelnav_2">
		<?php foreach($menu as $id=>$item): ?>
		<li id="modelnav-<?php echo $id; ?>">
			<?php echo $item[2]? '<span>'.$item[0].'</span>' : CHtml::link($item[0], $item[1]); ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</div>


<div class="model_gallery_2">
  <?php
	if($gallery->images) {
		$i=0;
		foreach($gallery->images as $image) {
			$i++;
			echo CHtml::link(
				CHtml::image($image->src['medium'], '', array('rel'=>'model_gallery')),
				$image->src['large']
			);
		}
	}
	?>
  <div class="clear"></div>  


  </div>	
	
</div>