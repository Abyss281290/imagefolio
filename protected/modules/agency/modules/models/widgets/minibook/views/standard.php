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
<div>
	<table style="margin-top:2px; width: 100%" border="0">
		<tr>
			<td valign="bottom" style="font-size:11px; width: 50%">
				<div>'.$model->agency->full_name.'</div>
				<div>'.$model->agency->address.'</div>
				<div>'.$model->agency->telephone.'</div>
			</td>
			<td align="right" valign="top" style="width: 10%">'.CHtml::image($site_logo_path).'</td>
		</tr>
	</table>
</div>';
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
			<?php
				foreach($characteristics as $c):
					if(in_array($c['type'], array('textarea','html'))) {
						//if($c['type'] == 'html')
						//	$c['value'] = strip_tags($c['value']);
						if(strlen($c['value']) > 250)
							$c['value'] = substr($c['value'], 0, 247).'...';
					}
			?>
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
			<div>
				<?php foreach($src_small as $img): ?>
				<?php echo CHtml::image($img,'',array('style'=>'margin-left: 0px; width: 14%')); ?>
				<?php endforeach; ?>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $info; ?></td>
	</tr>
</table>
<?php if(count($src_small2)): ?>
	<?php
	$limit = 24;
	$count = count($src_small2);
	$i = 0;
	foreach($src_small2 as $src):
	?>
		<?php if($i == 0 || $i%$limit==0): ?>
		<pagebreak />
		<div style="height: 650px">
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
		<?php endif; ?>
		<?php echo CHtml::image($src, '', array('style'=>'margin: 0px; width: 12%')); ?>
		<?php if($i+1 == $count || ($i+1)%$limit==0): ?>
			</div>
			<?php echo $info; ?>
		<?php endif; ?>
	<?php
			$i++;
		endforeach;
	?>
<?php endif; ?>