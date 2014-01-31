<li class="item">
	<?php
	$image = CHtml::image($data->mainImage, '', array('class'=>'imgportfolio imgbox'));
	echo CHtml::link($image, $this->createUrl('view', array('id'=>$data->id)));
	//echo $imageBig? CHtml::link($image, $imageBig) : $image;
	?>
	<h4>
		<?php echo $imageBig? CHtml::link(CHtml::encode($data->fullname), $imageBig) : CHtml::encode($data->fullname); ?>
	</h4>
</li>