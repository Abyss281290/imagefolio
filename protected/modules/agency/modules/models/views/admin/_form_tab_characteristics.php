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
$options = MenusHelper::getDropDownListTreeData($model->agency->id);
?>
<div class="form" style="border: none">
	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList(
				$model,
				'type_id',
				$options,
				array('empty'=>'- Not selected -')
		); ?>
		<?php echo $form->error($model, 'type_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'type2_id'); ?>
		<?php echo $form->dropDownList(
				$model,
				'type2_id',
				$options,
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