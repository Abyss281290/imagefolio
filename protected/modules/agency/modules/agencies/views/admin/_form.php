<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agencies-form',
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
			'tab_main' => array(
				'title'=>'Main',
				'view'=>'_form_tab_main',
				'data'=>array('form'=>$form, 'model'=>$model),
			),
			'tab_menu' => array(
				'title'=>'Menu',
				'content'=>$this->loadMenuView($model->id),
				'data'=>array('form'=>$form, 'model'=>$model),
			),
			'tab_pages' => array(
				'title'=>'Pages',
				'view'=>'_form_tab_pages',
				'data'=>array('form'=>$form, 'model'=>$model),
			)
		),
	));
	?>

<div class="row buttons" style="margin-top: 10px">
	<?php echo $form->label($model,''); ?>
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button blue')); ?>
	<?php if(Yii::app()->user->isAdmin()): ?>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo CHtml::link(Yii::t('main', 'Cancel'), $this->createUrl('index'), array('class'=>'button')); ?>
	<?php endif; ?>
</div>

<?php $this->endWidget(); ?>