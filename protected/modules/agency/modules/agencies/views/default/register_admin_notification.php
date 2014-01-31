<table>
	<tr>
		<th style="font-family: sans-serif; text-align: right; padding-bottom: 10px"><?php echo $model->getAttributeLabel('full_name'); ?></th>
		<td style="font-family: sans-serif; text-align: left; padding-bottom: 10px"><?php echo CHtml::encode($model->full_name); ?></td>
	</tr>
	<tr>
		<th style="font-family: sans-serif; text-align: right; padding-bottom: 10px"><?php echo $model->getAttributeLabel('date_registered'); ?></th>
		<td style="font-family: sans-serif; text-align: left; padding-bottom: 10px"><?php echo CHtml::encode($model->date_registered); ?></td>
	</tr>
	<tr>
		<th style="font-family: sans-serif; text-align: right; padding-bottom: 10px"><?php echo 'Admin link'; ?></th>
		<td style="font-family: sans-serif; text-align: left; padding-bottom: 10px"><?php echo CHtml::link($url = $model->getAdminUrl(), $url); ?></td>
	</tr>
	<tr>
		<th style="font-family: sans-serif; text-align: right; padding-bottom: 10px"><?php echo 'Front link'; ?></th>
		<td style="font-family: sans-serif; text-align: left; padding-bottom: 10px"><?php echo CHtml::link($url = $model->getFrontUrl(), $url); ?></td>
	</tr>
</table>