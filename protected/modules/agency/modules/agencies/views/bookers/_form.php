<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation' => true,
		'clientOptions'=>array(
			'validateOnSubmit' => true,
			'validateOnChange' => true,
			'validateOnType' => false,
		),
		'htmlOptions' => array(
			//'enctype' => 'multipart/form-data'
		),
	)); ?>

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
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'password2'); ?>
		<?php echo $form->passwordField($model,'password2',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fullname'); ?>
		<?php echo $form->textField($model,'fullname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'fullname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::label('',''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'button blue')); ?>
		<?php
		if(!Yii::app()->user->isBooker())
			echo CHtml::link('Cancel',$this->createUrl('index'),array('class'=>'button'));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->