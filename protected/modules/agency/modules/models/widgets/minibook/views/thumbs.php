<?php
$src_many = array();

foreach($images as $item) {
	//if (!$item->main)
	$src_many[] = $document_root.$item->src["medium"];
}

$info = '<table width="100%" border=0 style="margin-top: 50px">
	<tr>
		<td valign="top" style="padding-right: 40px">'.$site_address.'</td>
		<td align="right" valign="top" style="padding-right: 40px" rowspan=2>'.CHtml::image($site_logo_path).'</td>
	</tr>
</table>';
?>
<?php
if(count($src_many)):
	$c =  ceil(count($src_many)/10);
?>
<?php for($i = 1; $i <= $c; $i++): ?>
		<table width="100%" style="margin-bottom:50px">
			<tr>
				<td style="padding-left: 35px;">
					<?php echo $model->agency->image->exists? CHtml::image($model->agency->image->full) : ''; ?>
				</td>
				<td style="text-align: right; padding-right: 30px; font-size:30pt;"><?php echo $model->fullname; ?></td>
			</tr>
		</table>

		<table  width="100%" border="0">
			<?php for($j = 1; $j<=2; $j++): ?>
				<tr>
					<?php
					for($k = 1; $k <= 5; $k++):
					$n = -1 + $k+($j-1)*5 + ($i-1)*10;
					?>
						<td style="text-align: right; padding-right: 30px;" width="20%">
							<?php
							if($n < count($src_many))
								echo CHtml::image($src_many[$n]);
							?>
						</td>									
					<?php endfor; ?>
				</tr>
			<?php endfor; ?>
		</table>
		<?php if($n < count($src_many) -1 ): ?>
			<?php echo $info; ?>
			<pagebreak>
		<?php endif; ?>
	<?php endfor; ?>
<?php endif; ?>

<table width="100%" style="margin-top:50px" border=0>
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