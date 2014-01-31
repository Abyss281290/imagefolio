<?php
$type_ajax = array(
	'update' => '#characteristics',
	'url' => $this->createUrl('ajaxLoadCharacteristics'),
	'data' => "js:{model_id: ".intval($model->id).", type_id: $('#Models_type_id').val(), type2_id: $('#Models_type2_id').val()}",
	'cache' => false,
);
?>
<div class="form" style="border: none">
	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList(
				$model,
				'type_id',
				CHtml::listData(AgencyTypes::model()->findAll('active=1'),'id','title'),
				array('empty'=>'- Not selected -', 'ajax'=>$type_ajax)
		); ?>
		<?php echo $form->error($model, 'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type2_id'); ?>
		<?php echo $form->dropDownList(
				$model,
				'type2_id',
				CHtml::listData(AgencyTypes::model()->findAll('active=1'),'id','title'),
				array('empty'=>'- Not selected -', 'ajax'=>$type_ajax)
		); ?>
		<?php echo $form->error($model, 'type2_id'); ?>
	</div>

	<div id="characteristics">
		<?php $this->renderPartial('_form_characteristics',array(
			'model'=>$model,
			'type'=> $model->type,
			'type2'=> $model->type2,
		)); ?>
	</div>
</div>