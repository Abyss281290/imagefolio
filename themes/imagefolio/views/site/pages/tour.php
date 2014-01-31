<?php
//$model = ContentHelper::loadModel(3);
$this->widget('ext.colorbox.JColorBox')->addInstance('#features_video_link', array('inline'=>true));
?>
<div class="alpha grid_5">
	<h2><span class="red">Features</span></h2>
	<h3><span class="red">Video </span>Tour</h3>
	<?php echo CHtml::link(
			CHtml::image(Yii::app()->getTheme()->baseUrl.'/images/about_us-img-1.jpg','',array('class'=>'blo')),
			'#features_video',
			array('id'=>'features_video_link')
	); ?>

</div>
<div style="position: absolute; top: -9999px">
	<div id="features_video">
		<?php
		$this->widget('ext.videoPlayer.Player', array(
			'src' => Yii::app()->baseUrl.'/images/tour.flv',
			'width' => 640,
			'height' => 480,
		));
		?>
	</div>
</div>
<div class="omega grid_10 prefix_1 border-left">
	<div class="cells img-box-set">
		<dl>
			<dt>&nbsp;</dt>
			<dd>
Auto-cropping of images on upload, a wide variety of video formats accepted, automatic PDF "minibooks", broadcast emailed packages on multiple talents to multiple clients.
		 </dd>
		</dl>
		<dl>
			<dt>&nbsp;</dt>
			<dd>
Multiple Layouts available, with different colour schemes, customisable static pages, with a large number of standard talent types and divisions catered for. 
			</dd>
		</dl>
<div class="clear"></div>                        
		<dl>
			<dt>&nbsp;</dt>
			<dd>
Form based talent submission system, allowing easy assessment and management of talent applications.
			</dd>
		</dl>
		<dl>
			<dt>&nbsp;</dt>
			<dd>
Models characteristics available in Imperial (UK & US) & Metric (EU) and combinations, ability to host creatives including photographers, makeup artists, stylists to name but a few.							</dd>
		</dl>
	</div>
</div>