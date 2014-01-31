<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agency-plans-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'validateOnType' => false,
	),
)); ?>

	<?php //echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'models_allowed'); ?>
		<?php echo $form->textField($model,'models_allowed'); ?>
		<?php echo $form->error($model,'models_allowed'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->checkBox($model,'website'); ?>
		<?php echo $form->error($model,'website'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'packages'); ?>
		<?php echo $form->checkBox($model,'packages'); ?>
		<?php echo $form->error($model,'packages'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'submissions'); ?>
		<?php echo $form->checkBox($model,'submissions'); ?>
		<?php echo $form->error($model,'submissions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'images_allowed'); ?>
		<?php echo $form->textField($model,'images_allowed'); ?>
		<?php echo $form->error($model,'images_allowed'); ?>
	</div>

	<div class="row buttons">
		<?php echo $form->label($model,''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button blue')); ?>
		<?php if(Yii::app()->user->isAdmin()): ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo CHtml::link(Yii::t('main', 'Cancel'), $this->createUrl('index'), array('class'=>'button')); ?>
		<?php endif; ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->