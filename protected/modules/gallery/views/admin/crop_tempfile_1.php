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
	}
	img {
		max-width: none;
	}
</style>
<?php //echo CHtml::hiddenField('crop_x', array('value' => $crop_coords['x'])); ?>
<?php //echo CHtml::hiddenField('crop_y', array('value' => $crop_coords['y'])); ?>
<?php //echo CHtml::hiddenField('crop_w', array('value' => $crop_coords['w'])); ?>
<?php //echo CHtml::hiddenField('crop_h', array('value' => $crop_coords['h'])); ?>
<table class="crop" id="crop-table">
	<tr>
		<th>
			<?php $this->widget('ext.jcrop.jCropWidget',array(
				'imageUrl'=> Yii::app()->baseUrl.'/'.$this->module->tmpPath.'/'.CHtml::encode($_REQUEST['filename']),
				//'formElementX'=>'crop_x',
				//'formElementY'=>'crop_y',
				//'formElementWidth'=>'crop_w',
				//'formElementHeight'=>'crop_h',
				//'previewId'=>'avatar-preview', //optional preview image ID, see preview div below
				//'previewWidth'=>$previewWidth,
				//'previewHeight'=>$previewHeight,
				'jCropOptions'=>array(
					//'aspectRatio'=>1, 
					//'boxWidth'=>800,
					//'boxHeight'=>400,
					'minSize' => array(100, 100),
					'setSelect'=>array(
						(int)$crop_coords['x'],
						(int)$crop_coords['y'],
						(int)$crop_coords['x2'],
						(int)$crop_coords['y2']
					),
				),
			)
		); ?>
		</th>
		<td>
			<?php echo CHtml::button('Crop Image', array(
				'class' => 'button blue',
				'onclick' => 'return doCrop(this)',
				'id' => 'crop_button'
			)); ?>
			<?php echo CHtml::button('Cancel', array(
				'class' => 'button',
				'style' => 'margin-top: 5px',
				'onclick' => 'return cancelCrop()',
				'id' => 'crop_button'
			)); ?>
			<hr />
			<?php echo CHtml::button('Select all', array(
				'class' => 'button',
				'onclick' => 'return jcropSelectAll()',
				'id' => 'crop_button'
			)); ?>
		</td>
	</tr>
</table>
<script type="text/javascript">
var _c; // current coords
function doCrop(btn)
{
	//$('#crop_button').attr('disabled', true);
	top.Gallery.cropTempFileSave(<?php echo $_REQUEST['fieldNum']; ?>,
	{
		x: gcc('x'),
		y: gcc('y'),
		x2: gcc('x2'),
		y2: gcc('y2'),
		w: gcc('w'),
		h: gcc('h')
	});
	if(top != self) {
		top.$.colorbox.close();
	}
}

function cancelCrop()
{
	if(top != self) {
		top.$.colorbox.close();
	}
}

function gcc(key)
{
	return _c[key];
}

function updateCoords1(c)
{
	_c = c;
}

function jcropSelectAll()
{
	var img = $('#yii-jcrop-1');
	jcrop.setSelect([0, 0, img.width(), img.height()]);
	return false;
}

if(top != self) {
	var ff = function()
	{
		var obj = $(document);
		var w = obj.width()+10;
		var h = obj.height()+10;
		top.$.colorbox.resize({innerWidth: w, innerHeight: h});
	}
	$('#yii-jcrop-1').load(ff);
}

$(document).ready(function(){
	setTimeout(function(){
		<?php if(!$crop_coords): ?>
		var f = function()
		{
			if(jcrop)
				jcropSelectAll();
			else
				setTimeout(f, 20);
		}
		f();
		<?php endif; ?>
	}, 100);
});
</script>