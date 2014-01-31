<h5>New contact</h5>
<table>
	<tr>
		<th><?php echo $model->getAttributeLabel('name'); ?></th>
		<td><?php echo CHtml::encode($model->name); ?></td>
	</tr>
	<?php /* <tr>
		<th><?php echo $model->getAttributeLabel('agency_name'); ?></th>
		<td><?php echo CHtml::encode($model->agency_name); ?></td>
	</tr> */ ?>
	<tr>
		<th><?php echo $model->getAttributeLabel('email'); ?></th>
		<td><?php echo CHtml::encode($model->email); ?></td>
	</tr>
	<tr>
		<th><?php echo $model->getAttributeLabel('message'); ?></th>
		<td><?php echo CHtml::encode($model->message); ?></td>
	</tr>
</table>