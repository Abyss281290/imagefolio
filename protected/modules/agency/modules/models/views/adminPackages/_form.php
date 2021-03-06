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
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'front_link'); ?>
		<?php echo CHtml::link(ModelsPackagesHelper::getFrontViewLink($model),ModelsPackagesHelper::getFrontViewLink($model),array('target'=>'_blank')); ?>
	</div>
	
	<div class="row buttons">
		<?php echo $form->labelEx($model,''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button blue')); ?>
		<?php echo CHtml::link('Cancel',$this->createUrl('index'),array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->