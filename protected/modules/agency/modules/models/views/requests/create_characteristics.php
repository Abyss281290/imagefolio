<?php
$primary_type_ids = array();
?>
<div class="row">
	<?php foreach(array('type'=>$type) as $tk => $t): ?>
		<?php if($t): ?>
		<fieldset>
			<?php /* <legend><b><?php echo CHtml::encode($t->title); ?></b> type characteristics</legend> */ ?>
			<table>
				<?php if($count = count($t->characteristics)): ?>
				<?php
				$i=0;
				foreach($t->characteristics as $c):
				?>
					<?php if($i%2==0 || $i==0): ?>
					<tr>
					<?php endif; ?>
						<th><?php echo CHtml::encode($c->title); ?></th>
						<td>
							<?php if(in_array($c->id, $primary_type_ids)): ?>
							Reference to the <?php echo CHtml::encode($type->title); ?> type
							<?php else: ?>
							<?php $c->renderElement($model, $tk.'_values'); ?>
							<?php endif; ?>
						</td>
					<?php
					$primary_type_ids[] = $c->id;
					$i++;
					if($i%2==0 || $i>=$count):
					?>
					</tr>
					<?php endif; ?>
				<?php
					endforeach;
				?>
				<?php else: ?>
				No characteristics
				<?php endif; ?>
			</table>
		</fieldset>
		<?php endif; ?>
	<?php endforeach; ?>
</div>