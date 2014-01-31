<?php
$type_ajax = array(
	'update' => '#element_data',
	'url' => $this->createUrl('ajaxLoadElementData'),
	'data' => "js:{characteristicId: ".intval($model->id).", selectedType: $('#AgencyCharacteristics_type').val()}",
	'cache' => false,
);
?>
<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agency-characteristics-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'validateOnType' => false,
	),
)); ?>
	
	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('cols'=>60)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList(
			$model,
			'type',
			CharacteristicsHelper::getElementTypes(),
			array(
				'empty'=>'- Not selected -',
				'ajax'=>$type_ajax,
				'onchange'=>"$('#element_data').html('".CHtml::image(Yii::app()->baseUrl . '/'. Yii::app()->params['ajaxLoader'], '', array('style'=>'margin:20px'))."')"
			)
		); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
	
	<div id="element_data">
		<?php $this->renderPartial('_form_element_data', array(
			'selectedType'=>$model->type,
			'model'=>$model
		)); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::label('',''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button blue')); ?>
		<?php echo CHtml::link('Cancel',$this->createUrl('index'),array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->