<div class="form" style="border: none">
	<div class="row">
		<?php echo $form->labelEx($model,'agency_id'); ?>
		<?php if(!Yii::app()->user->isAdmin()): ?>
			<?php echo $form->hiddenField($model, 'agency_id'); ?>
			<div style="padding: 6px 0; font-weight: bold"><?php echo CHtml::encode($model->agency->full_name); ?></div>
		<?php else: ?>
			<?php echo $form->dropDownList($model, 'agency_id', AgencyHelper::getAgenciesIdTitle(), array('empty'=>'- Not selected -')); ?>
			<?php echo $form->error($model, 'agency_id'); ?>
		<?php endif; ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model, 'firstname', array('size'=>'60','maxlength'=>255)); ?>
		<?php echo $form->error($model, 'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model, 'lastname', array('size'=>'60','maxlength'=>255)); ?>
		<?php echo $form->error($model, 'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model, 'email', array('size'=>'60','maxlength'=>255)); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birth_place'); ?>
		<?php echo $form->textField($model, 'birth_place', array('size'=>'60','maxlength'=>255)); ?>
		<?php echo $form->error($model, 'birth_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birthday'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$model,
			'attribute'=>'birthday',
			'options'=>array(
				'showAnim'=>'fold',
				'changeMonth'=>true,
				'changeYear'=>true,
				'yearRange'=>'c-100:c+0'
			),
			'htmlOptions'=>array('class'=>'textfield'),
		));
		?>
		<?php echo $form->error($model, 'birthday'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ethnicity'); ?>
		<?php echo $form->textField($model, 'ethnicity', array('size'=>'60','maxlength'=>255)); ?>
		<?php echo $form->error($model, 'ethnicity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model, 'telephone', array('size'=>'60','maxlength'=>255)); ?>
		<?php echo $form->error($model, 'telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model, 'address', array('rows'=>6, 'cols'=>60)); ?>
		<?php echo $form->error($model, 'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model, 'text', array('rows'=>6, 'cols'=>60)); ?>
		<?php echo $form->error($model, 'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'union'); ?>
		<?php echo $form->dropDownList($model, 'union', array(
			'Non union'=>'Non union',
			'Union'=>'Union'
		)); ?>
		<?php echo $form->error($model, 'union'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'commercials_ask'); ?>
		<?php echo $form->dropDownList($model, 'commercials_ask', array(
			'Commercials yes'=>'Commercials yes',
			'Commercials no'=>'Commercials no',
			'Commercials ask first'=>'Commercials ask first'
		)); ?>
		<?php echo $form->error($model, 'commercials_ask'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nudity_ask'); ?>
		<?php echo $form->dropDownList($model, 'nudity_ask', array(
			'Nudity yes'=>'Nudity yes',
			'Nudity no'=>'Nudity no',
			'Nudity ask first'=>'Nudity ask first'
		)); ?>
		<?php echo $form->error($model, 'nudity_ask'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lingerie_ask'); ?>
		<?php echo $form->dropDownList($model, 'lingerie_ask', array(
			'Lingerie yes'=>'Lingerie yes',
			'Lingerie no'=>'Lingerie no',
			'Lingerie ask first'=>'Lingerie ask first'
		)); ?>
		<?php echo $form->error($model, 'lingerie_ask'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shows_ask'); ?>
		<?php echo $form->dropDownList($model, 'shows_ask', array(
			'Shows yes'=>'Shows yes',
			'Shows no'=>'Shows no',
			'Shows ask first'=>'Shows ask first'
		)); ?>
		<?php echo $form->error($model, 'shows_ask'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model, 'active', array(1=>T::_('yes'), 0=>T::_('no'))); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>
</div>