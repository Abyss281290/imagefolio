<?php
$this->title = 'Agencies';
?>
<?php if($items): ?>
<div class="agencies-list">
	<ul>
	<?php foreach($items as $item): ?>
		<li>
			<a href="<?php echo CHtml::encode($this->createUrl('view', array('id'=>$item->id))); ?>">
				<h5><?php echo $item->full_name; ?></h5>
				<?php echo CHtml::image($item->image->full); ?>
			</a>
		</li>
	<?php endforeach; ?>
	</ul>
</div>
<?php else: ?>
No agencies found
<?php endif; ?>