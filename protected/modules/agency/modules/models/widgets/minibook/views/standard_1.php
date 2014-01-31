<?php
$src_small = array();
$src_small2 = array();

foreach($images as $item) {
	if($mainImage == $document_root.$item->src['large']) continue;
	else {
		//forming 2 arrays to operate with 2nd page separately
		if(count($src_small) <= 3)  $src_small[] = $document_root.$item->src["medium"];
		else $src_small2[] = $document_root.$item->src["medium"];
	}
}

$info = '
<table style="margin-top:2px; width: 100%" border="0">
	<tr>
		<td valign="top" style="font-size:11px; width: 50%">
			<div>'.$model->agency->full_name.'</div>
			<div>'.$model->agency->address.'</div>
			<div>'.$model->agency->telephone.'</div>
		</td>
		<td align="right" valign="top" style="width: 10%">'.CHtml::image($site_logo_path).'</td>
	</tr>
</table>';
//$info = '123';
?>
<table width="100%" border="0">
	<tr>
		<td align="left">
		<?php if($model->agency->image->exists): ?>
			<?php echo CHtml::image($document_root.$model->agency->image->full); ?>
		<?php endif; ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td style="text-align: center; width: 30%" rowspan="3">
			<?php echo CHtml::image($mainImage,'',array('width'=>'40%')); ?>
		</td>
		<td align="center" style="vertical-align: top;">
			<p style="font-size:32pt; "><?php echo $model->fullname; ?></p>
		</td>
	</tr>
	<tr>
		<td align="center" style="vertical-align: middle;">&nbsp;
		<?php if($characteristics = $model->characteristicsTitleValue): ?>
			<table>
			<?php foreach($characteristics as $c): ?>
				<tr>
					<td style="padding-right:30px; vertical-align: top; font-size: 11px"><?php echo $c['title']; ?></td>
					<td style="font-size: 11px"><?php echo $c['value']; ?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
		</td>
	</tr>
	<tr>
		<td style="text-align: right;" valign="bottom">
		<?php foreach($src_small as $img): ?>
			<?php echo CHtml::image($img,'',array('style'=>'margin-left: 0px; width: 14%')); ?>
		<?php endforeach; ?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $info; ?></td>
	</tr>
</table>
<?php if(count($src_small2)): ?>
<pagebreak />
	<?php
	$c =  ceil(count($src_small2)/10);
	for($i = 1; $i <= $c; $i++):
	?>
		<table style="width: 100%">
			<tr>
				<td>
					<?php if($model->agency->image->exists): ?>
						<?php echo CHtml::image($document_root.$model->agency->image->full); ?>
					<?php endif; ?>
				</td>
				<td align="right">
					<p style="text-align: right; font-size:30pt;"><?php echo $model->fullname; ?></p>
				</td>
			</tr>
		</table>
		<table  width="100%" border="0">
		<?php for($j = 1; $j<=2; $j++): ?>
			<tr>
				<td>
				<?php
				for($k = 1; $k <= 8; $k++):
					$n = -1 + $k+($j-1)*8 + ($i-1)*10;
				?>
					<?php
					if($n < count($src_small2))
						echo CHtml::image($src_small2[$n], '', array('style'=>'margin: 0px; width: 12%'));
					?>									
				<?php endfor; ?>
				</td>
			</tr>
		<?php endfor; ?>
		</table>
			<?php if($n < count($src_small2) -1 ): ?>
			<pagebreak />
			<?php endif; ?>
	<?php endfor; ?>
	<?php echo $info; ?>
<?php endif; ?>