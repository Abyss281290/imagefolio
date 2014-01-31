<?php
$src_pair = array();

foreach($images as $item) {
	$src_pair[] = $document_root.$item->src["large"];
}

$info = '<table width="100%" border=0 style="margin-top: 30px">
	<tr>
		<td valign="top" style="padding-right: 40px">'.$site_address.'</td>
		<td align="right" valign="top" style="padding-right: 40px" rowspan=2>'.CHtml::image($site_logo_path).'</td>
	</tr>
</table>';
?>
<?php
$c = ceil(count($src_pair)/2);
for($i = 0; $i <count($src_pair); $i+=2):
	//<p style="text-align: right; padding-right: 65px; font-size:32pt;">{$fullname}</p>
?>
	<table width="100%" border="0">
		<tr>
			<td style="padding-left: 65px;">
				<?php echo $model->agency->image->exists? CHtml::image($model->agency->image->full) : ''; ?>
			</td>
			<td style="padding: 0 65px; text-align: right; font-size:32pt;"><?php echo $model->fullname; ?></td>
		</tr>
		<tr>
			<td style="padding-right: 65px; text-align: right; width:50%;">
				<?php echo CHtml::image($src_pair[$i]); ?>
			</td>
			<td style="padding-right: 65px; text-align: right; width:50%;">
				<?php
				if(isset($src_pair[$i+1]))
					echo CHtml::image($src_pair[$i+1]);
				?>
			</td>
		</tr>
	</table>
	<?php echo $info; ?>
	<pagebreak />
<?php endfor; ?>
<table width="100%" border=0>
	<tr>
		<td style="padding-bottom:20px; font-size: 12px">
		<?php if($characteristics = $model->characteristicsTitleValue): ?>
			<?php foreach($characteristics as $c): ?>
				<?php echo $c['title']; ?>: <?php echo $c['value']; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		</td>
	</tr>
</table>
<?php echo $info; ?>