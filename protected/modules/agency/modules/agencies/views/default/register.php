<?php
$this->title = 'Register Agency';
$this->pageTitle = 'Register Agency';

Yii::app()->clientScript->registerCssFile($this->module->assetPath.'/css/front/register.css');
?>
<div class="form agency-register" id="maincontactform">
	
	<div class="description">
Please complete this form to start the creation of your main agency account, this account will have elevated privileges<br />
including view and make payment of invoices, view package reports of all bookers, change available talent types,<br />
alter agency layout and colour scheme. You can also create “Booker” accounts later for day to day administration for individual users,<br />
i.e. to add, edit & delete talents and clients, upload images & video to the galleries, send packages and view submissions.
	</div>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agencies-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation' => true,
	'clientOptions'=>array(
		'validateOnSubmit' => true,
		'validateOnChange' => true,
		'validateOnType' => false,
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data'
	),
)); ?>
	
	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'short_name'); ?>
		<?php echo $form->textField($model,'short_name',array('size'=>60,'maxlength'=>255,'class'=>'textfield')); ?>
		<?php echo $form->error($model,'short_name'); ?>
		<div class="hint">A short name that you call your agency i.e. “The Mode” (can be the same as the full name)</div>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'full_name'); ?>
		<?php echo $form->textField($model,'full_name',array('size'=>60,'maxlength'=>255,'class'=>'textfield')); ?>
		<?php echo $form->error($model,'full_name'); ?>
		<div class="hint">The full name of your agency i.e. “The Mode Model Management Ltd”</div>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('size'=>60,'maxlength'=>255,'class'=>'textfield')); ?>
		<?php echo $form->error($model,'telephone'); ?>
		<div class="hint">Your agencies main phone number including code, i.e. +1 500 555 1234</div>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'owner_login'); ?>
		<?php echo $form->textField($model,'owner_login',array('size'=>60,'maxlength'=>255,'autocomplete'=>'off','class'=>'textfield')); ?>
		<?php echo $form->error($model,'owner_login'); ?>
		<div class="hint">Choose a unique login name for the account that will have the highest privileges i.e. “JaneSmith”</div>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'owner_password'); ?>
		<?php echo $form->passwordField($model,'owner_password',array('size'=>60,'maxlength'=>255,'autocomplete'=>'off','class'=>'textfield')); ?>
		<?php echo $form->error($model,'owner_password'); ?>
		<div class="hint">We recommend you use a strong password for all accounts</div>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'owner_password2'); ?>
		<?php echo $form->passwordField($model,'owner_password2',array('size'=>60,'maxlength'=>255,'autocomplete'=>'off','class'=>'textfield')); ?>
		<?php echo $form->error($model,'owner_password2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_email'); ?>
		<?php echo $form->textField($model,'owner_email',array('size'=>60,'maxlength'=>255,'class'=>'textfield')); ?>
		<?php echo $form->error($model,'owner_email'); ?>
		<div class="hint">The email of the user that will have the highest privileges in the agency</div>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::label('&nbsp;',''); ?>
		<?php echo CHtml::linkButton('<span>Register</span>', array('class'=>'button')); ?>
	</div>
	<div class="clear"></div>
<?php $this->endWidget(); ?>

</div><!-- form -->