<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'models-packages-reports-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'package_id'); ?>
		<?php echo $form->textField($model,'package_id'); ?>
		<?php echo $form->error($model,'{langName}'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sender_role'); ?>
		<?php echo $form->textField($model,'sender_role',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'{langName}'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sender_user_id'); ?>
		<?php echo $form->textField($model,'sender_user_id'); ?>
		<?php echo $form->error($model,'{langName}'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recipient_name'); ?>
		<?php echo $form->textField($model,'recipient_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'{langName}'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recipient_email'); ?>
		<?php echo $form->textField($model,'recipient_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'{langName}'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->