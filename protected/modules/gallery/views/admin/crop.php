<?php
$imageSize = array(525,700);
$selectorSize = array(400,520);
?>
<style type="text/css">
	table.crop {
		width: auto;
	}
	table.crop th,
	table.crop td {
		vertical-align: top;
	}
	table.crop th {
		padding-right: 10px;
		border: none;
	}
	img {
		max-width: none;
	}
</style>
<table class="crop" id="crop-table">
	<tr>
		<th>
			<?php $this->widget('ext.cropzoom.JCropZoom', array(
				'id' => 'cropZoom1',
				'cropTriggerId'=>'crop_button',
				'callbackUrl'=>$this->createUrl('ajaxDoCrop', array('image_id'=>$model->id)),
				//'containerId'=>'crop_container1',
				'onServerHandled' => 'js:cropAfterSave',
				'image'=>array(
					'source'=>$model->srcOriginal,
					//'x'=>(int)$model->crop_data['imageX'],
					//'y'=>(int)$model->crop_data['imageY'],
					'x'=>'js:(($(window).width() / 2) - '.$imageSize[0].' / 2)',
					'y'=>'js:(($(window).height() / 2) - '.$imageSize[1].' / 2)',
					//'width'=>(int)$model->crop_data['imageW'],
					//'height'=>(int)$model->crop_data['imageH'],
					'minZoom'=>1,
					'maxZoom'=>100,
					'startZoom'=>100,
					'snapToContainer'=>false
					//'rotation'=>(int)$model->crop_data['imageRotate']
				),
				'zoomSteps'=>1,
				'width'=>525,
				'height'=>700,
				'selector'=>array(
					//'x'=>(int)$model->crop_data['selectorX'],
					//'y'=>(int)$model->crop_data['selectorY'],
					'centered'=>true,
					'w'=>$selectorSize[0],
					'h'=>$selectorSize[1],
					'minWidth'=>100,
					'minHeight'=>ceil(100/($selectorSize[0]/$selectorSize[1])),
					//'centered'=>false,
					'aspectRatio'=>$selectorSize[0]/$selectorSize[1],
					'showPositionsOnDrag'=>false,
				)
			)); ?>
		</th>
		<td>
			<?php echo CHtml::button('Crop Image', array(
				'class' => 'button blue',
				'id' => 'crop_button'
			)); ?>
			<?php echo CHtml::button('Cancel', array(
				'class' => 'button',
				'onclick' => 'return cancelCrop()',
				'style'=>'margin-top:5px'
			)); ?>
			<hr />
			<?php echo CHtml::button('Restore image', array(
				'class' => 'button',
				'onclick' => 'return restoreCrop()'
			)); ?>
		</td>
	</tr>
</table>
<script type="text/javascript">
if(top != self) {
	top.$.colorbox.resize({
		innerWidth: <?php echo $imageSize[0]; ?>+150,
		innerHeight: <?php echo $imageSize[1]; ?>+10
	});
}

function cropAfterSave()
{
	if(top != self) {
		top.Gallery.reloadImage(<?php echo $model->id; ?>);
		top.$.colorbox.close();
	}
}

function cancelCrop()
{
	if(top != self) {
		top.$.colorbox.close();
	}
}

function restoreCrop()
{
	cropZoom1.restore();
}
</script>