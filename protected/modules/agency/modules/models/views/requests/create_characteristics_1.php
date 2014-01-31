<?php
$primary_type_ids = array();
?>
<div class="row">
	<?php foreach(array('type'=>$type) as $tk => $t): ?>
		<?php if($t): ?>
		<fieldset>
			<legend><b><?php echo CHtml::encode($t->title); ?></b> type characteristics</legend>
			<?php if(count($t->characteristics)): ?>
			<?php foreach($t->characteristics as $c): ?>
				<div class="row">
					<table style="width: auto">
						<tr>
							<th><?php $c->renderElementLabel($model, $tk.'_values'); ?></th>
							<td>
								<?php if(in_array($c->id, $primary_type_ids)): ?>
								Reference to the <?php echo CHtml::encode($type->title); ?> type
								<?php else: ?>
								<?php $c->renderElement($model, $tk.'_values'); ?>
								<?php endif; ?>
							</td>
						</tr>
					</table>
				</div>
			<?php
					$primary_type_ids[] = $c->id;
				endforeach;
			?>
			<?php else: ?>
			No characteristics
			<?php endif; ?>
		</fieldset>
		<?php endif; ?>
	<?php endforeach; ?>
</div>