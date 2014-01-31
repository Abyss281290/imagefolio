<?php
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScriptFile($this->module->assetPath.'/js/jquery.rotate.min.js');

$imageSize = $model->getImageSize();
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
	}
	img {
		max-width: none;
	}
	
	.sliders {
	}
	.sliders td {
		text-align: center;
		border: 4px solid #fff;
	}
	.slider .title {
		background: #eee;
	}
	.slider .title span {
	}
	.slider-item {
		margin: 0 auto;
	}
	.slider .ui-slider-vertical {
		height: 150px;
	}
	.slider .val {
		font-weight: bold;
		font-family: cursive;
	}
	.slider.zoom .val {
		font-family: cursive;
		font-size: 20px;
		font-weight: bold;
	}
	.jcrop-holder {
		overflow: hidden
	}
</style>
<?php //echo CHtml::hiddenField('crop_x', array('value' => $model->crop_coords['x'])); ?>
<?php //echo CHtml::hiddenField('crop_y', array('value' => $model->crop_coords['y'])); ?>
<?php //echo CHtml::hiddenField('crop_w', array('value' => $model->crop_coords['w'])); ?>
<?php //echo CHtml::hiddenField('crop_h', array('value' => $model->crop_coords['h'])); ?>
<table class="crop" id="crop-table">
	<tr>
		<th>
			<?php $this->widget('ext.jcrop.jCropWidget',array(
				'imageUrl'=> $model->srcOriginal.'?'.time(),
				//'formElementX'=>'crop_x',
				//'formElementY'=>'crop_y',
				//'formElementWidth'=>'crop_w',
				//'formElementHeight'=>'crop_h',
				//'previewId'=>'avatar-preview', //optional preview image ID, see preview div below
				//'previewWidth'=>$previewWidth,
				//'previewHeight'=>$previewHeight,
				'jCropOptions'=>array(
					'aspectRatio'=> 340/454,
					//'boxWidth'=>800,
					//'boxHeight'=>400,
					//'minSize' => array(340, 454),
					'setSelect'=>array(
						(int)$model->crop_coords['x'],
						(int)$model->crop_coords['y'],
						(int)$model->crop_coords['x2'],
						(int)$model->crop_coords['y2']
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
			<?php /*
			<hr />
			<?php echo CHtml::button('Select all', array(
				'class' => 'button',
				'onclick' => 'return jcropSelectAll()',
				'id' => 'crop_button'
			)); ?>
			*/ ?>
			<hr />
			<table class="sliders">
				<tr>
					<td>
						<div id="slider-rotate" class="slider rotate">
							<div class="title">Rotate (<span>0</span>&deg;)</div>
							<div class="val min">360&deg;</div>
							<div class="slider-item"></div>
							<div class="val max">0&deg;</div>
						</div>
					</td>
					<td>
						<div id="slider-zoom" class="slider zoom">
							<div class="title">Zoom (<span>100</span>%)</div>
							<div class="val min">+</div>
							<div class="slider-item"></div>
							<div class="val max">-</div>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript">
var _c; // current coords
var rotate = 0;
var zoom = 100;
var imageSize = [<?php echo (int)$imageSize[0]; ?>, <?php echo (int)$imageSize[1]; ?>];

function doCrop(btn)
{
	$('#crop_button').attr('disabled', true);
	$.ajax({
		url: "<?php echo $this->createUrl('ajaxDoCrop'); ?>",
		data: {
			image_id: <?php echo $model->id; ?>,
			x: gcc('x'),
			y: gcc('y'),
			x2: gcc('x2'),
			y2: gcc('y2'),
			w: gcc('w'),
			h: gcc('h'),
			rotate: rotate,
			zoom: zoom
		},
		type: 'POST',
		//context: document.body,
		success: function(r)
		{
			if(top != self) {
				top.Gallery.reloadImage(<?php echo $model->id; ?>);
				top.$.colorbox.close();
			}
		}
	});
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

<?php if(!$model->crop_coords): ?>
$('#yii-jcrop-1').load(function()
{
	if(jcrop)
		jcropSelectAll();
	else
		setTimeout(f, 20);
});
<?php endif; ?>

$(function() {
	$("#slider-rotate .slider-item").slider({
		orientation: 'vertical',
		range: 'min',
		max: 360,
		value: rotate,
		slide: function(event, ui)
		{
			rotate = ui.value;
			$('.jcrop-holder img').rotate(ui.value);
			$('#slider-rotate .title span').text(rotate);
		}
	});
	$("#slider-zoom .slider-item").slider({
		orientation: 'vertical',
		range: 'min',
		max: 300,
		value: zoom,
		slide: function(event, ui)
		{
			zoom = ui.value;
			var w = imageSize[0]/100*zoom;
			var h = imageSize[1]/100*zoom;
			$('.jcrop-holder img').width(w);
			$('.jcrop-holder img').height(h);
			$('#slider-zoom .title span').text(zoom);
		}
	});
});
</script>