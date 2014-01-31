<?php
Yii::app()->clientScript->registerScript(
  "load-characteristics",
  "$('#".CHtml::activeId($model,'type_id')."').live('change', function(){
		$.ajax({
			type: 'GET',
			url: '".$this->createUrl('ajaxLoadCharacteristics')."',
			data: {model_id: ".intval($model->id).", type_id: $('#".CHtml::activeId($model,'type_id')."').val(), type2_id: ($('#".CHtml::activeId($model,'type2_id')."').val() || 0)},
			cache: false,
			success: function(html)
			{
				$('#characteristics').html(html);
			}
		})
	});
  "
);
$characteristicsOptions = MenusHelper::getDropDownListTreeData($model->agency->id);
?>
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
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model, 'url', array('size'=>'60','maxlength'=>255)); ?>
		<?php echo $form->error($model, 'url'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList(
				$model,
				'type_id',
				$characteristicsOptions,
				array('empty'=>'- Not selected -')
		); ?>
		<?php echo $form->error($model, 'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type2_id'); ?>
		<?php echo $form->dropDownList(
				$model,
				'type2_id',
				$characteristicsOptions,
				array('empty'=>'- Not selected -')
		); ?>
		<?php echo $form->error($model, 'type2_id'); ?>
	</div>
	
	<div id="characteristics">
		<?php $this->renderPartial('_form_characteristics',array(
			'model'=>$model,
			'type'=> $model->type,
			//'type2'=> $model->type2,
		)); ?>
	</div>
</div>