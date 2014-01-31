<?php if($data->items): ?>
<table class="invoice-items">
	<?php foreach($data->items as $item): ?>
	<tr>
		<td class="title"><?php echo Chtml::encode($item->title); ?></td>
		<td class="price"><?php echo '$'.number_format($item->price,2); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>