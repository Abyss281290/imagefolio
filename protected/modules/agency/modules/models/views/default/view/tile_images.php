<?php
if($images) {
	$i=0;
	foreach($images as $image) {
		$i++;
		echo CHtml::link(
			CHtml::image($image->src['medium'], '', array('rel'=>'model_gallery')),
			$image->src['large'],
			array('class'=>'image')
		);
	}
}
?>