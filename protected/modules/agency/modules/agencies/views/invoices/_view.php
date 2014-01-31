<tr class="item">
	<td><?php echo CHtml::encode($data->title); ?></td>
	<td><?php echo CHtml::encode($data->description); ?></td>
	<td><?php echo '$'.number_format($data->price,2); ?></td>
</tr>