<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'models-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'validateOnType' => false,
		'afterValidate'=>'js:function(){ var f=$(".row.error :input:first"); if(f.length) f.focus(); else return true }',
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data'
	),
)); ?>
	
	<?php echo $form->errorSummary($model); ?>
	
	<?php
	$this->widget('CTabView',array(
        'tabs'=>array(
			'tab_1' => array(
				'id'=>'tab1_id1',
				'title'=>'Main',
				'view'=>'_form_tab_main',
				'data'=>array('form'=>$form, 'model'=>$model),
			),
			'tab_2' => array(
				'title'=>'Additional data',
				'view'=>'_form_tab_additional_data',
				'data'=>array('form'=>$form, 'model'=>$model),
			),
		),
	));
	?>
	
	<?php /*
	<div class="row">
		<?php echo CharacteristicsHelper::renderType($model, 'growth', 'list', 'a:4:{i:168;s:5:"168cm";i:169;s:5:"169cm";i:170;s:5:"170cm";i:171;s:5:"171cm";}'); ?>
	</div> */ ?>
	
	<?php /*
	<?php if($model->created_by_obj): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $model->created_by_obj->username; ?>
		<br /><?php echo $model->created_time; ?>
	</div>
	<?php endif; ?>
	
	<?php if($model->updated_by_obj): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'updated'); ?>
		<?php echo $model->updated_by_obj->username; ?>
		<br /><?php echo $model->updated_time; ?>
	</div>
	<?php endif; ?>
	*/ ?>
	
	<div class="row buttons" style="margin-top: 10px">
		<?php echo $form->label($model,''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button blue')); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo CHtml::link(Yii::t('main', 'Cancel'), $this->createUrl('index'), array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>