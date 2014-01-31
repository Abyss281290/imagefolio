<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->label($model, 'value', array('label'=>$model->key)); ?>
		<?php echo $form->textarea($model,'value',array('autocomplete'=>'off','cols'=>100)); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo $form->label($model,''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button blue')); ?>
		<?php echo CHtml::link('Cancel',$this->createUrl('index'),array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->