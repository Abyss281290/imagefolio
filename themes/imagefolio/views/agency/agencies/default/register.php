<?php
$this->layout = false;
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getTheme()->baseUrl.'/js/jquery.form-defaults.js');
Yii::app()->clientScript->registerCssFile($this->module->assetPath.'/css/front/register.css');
?>
<script type="text/javascript">
function registerSubmit()
{
	var form = $("#register #form2");
	form.submit(function(e){ e.preventDefault() });
	form.trigger("submit");
	jQuery.ajax({
		'type':'POST',
		'url':form.attr('action'),
		'cache':false,
		'data':form.serialize(),
		success:function(data)
		{
			if(data == '') {
				//form.get(0).reset();
				$("#register_success").show(200, function() {
					setTimeout($.proxy(function() {
						$(this).hide(400);
					}, this), 4000);
				});
			}
		}
	});
	return false;
}

$(function() {
	$("#register #form2 :input").each(function(k,v) {
		var val = $(v).val();
		$(v).val('');
		$(v).DefaultValue(val);
	});
});
</script>
<div class="alpha grid_5">
					<h2><span class="red">registration</span> form</h2>
Please complete this form to start the creation of your main agency account, this account will have elevated privileges
including view and make payment of invoices, view package reports of all bookers, change available talent types,
alter agency layout and colour scheme. You can also create “Booker” accounts later for day to day administration for individual users,
i.e. to add, edit & delete talents and clients, upload images & video to the galleries, send packages and view submissions.
				</div>
				<div class="omega grid_10 prefix_1 border-left form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>$this->createUrl('/agency/agencies/default/register'),
	'id'=>'form2',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<div class="left">
	<div id="register_success" class="notification success" style="display: none">
		<h5>Please confirm your registration by clicking on the link that has now been sent to you by email.</h5>
	</div>
					  <fieldset>
						<div class="row">
							<?php if(strval($model->short_name) === '') $model->short_name = $model->getAttributeLabel('short_name'); ?>
							<?php echo $form->textField($model,'short_name',array('class'=>'textfield')); ?>
							<?php echo $form->error($model,'short_name'); ?>
							<div class="hint">A short name that you call your agency i.e. “The Mode” (can be the same as the full name)</div>
						</div>

						<div class="row">
							<?php if(strval($model->full_name) === '') $model->full_name = $model->getAttributeLabel('full_name'); ?>
							<?php echo $form->textField($model,'full_name',array('class'=>'textfield')); ?>
							<?php echo $form->error($model,'full_name'); ?>
							<div class="hint">The full name of your agency i.e. “The Mode Model Management Ltd”</div>
						</div>


						<div class="row">
							<?php if(strval($model->telephone) === '') $model->telephone = $model->getAttributeLabel('telephone'); ?>
							<?php echo $form->textField($model,'telephone',array('class'=>'textfield')); ?>
							<?php echo $form->error($model,'telephone'); ?>
							<div class="hint">Your agencies main phone number including code, i.e. +1 500 555 1234</div>
						</div>

						<div class="row">
							<?php if(strval($model->owner_login) === '') $model->owner_login = $model->getAttributeLabel('owner_login'); ?>
							<?php echo $form->textField($model,'owner_login',array('class'=>'textfield')); ?>
							<?php echo $form->error($model,'owner_login'); ?>
							<div class="hint">Choose a unique login name for the account that will have the highest privileges i.e. “JaneSmith”</div>
						</div>
                          
                          
						<div class="row">
							<?php if(strval($model->owner_email) === '') $model->owner_email = $model->getAttributeLabel('owner_email'); ?>
							<?php echo $form->textField($model,'owner_email',array('class'=>'textfield')); ?>
							<?php echo $form->error($model,'owner_email'); ?>
							<div class="hint">The email of the user that will have the highest privileges in the agency</div>
						</div>
                          
						<br class="clear">
					  </fieldset>

</div>
<div class="right  border-left">
		
					  <fieldset>

						<div class="row">
							<?php //if(strval($model->owner_password) === '') $model->owner_password = $model->getAttributeLabel('owner_password'); ?>
							<?php echo $form->passwordField($model,'owner_password',array('class'=>'textfield')); ?>
							<?php echo $form->error($model,'owner_password'); ?>
							<div class="hint">We recommend you use a strong password for all accounts</div>
						</div>
                          
						<div class="row">
							<?php //if(strval($model->owner_password2) === '') $model->owner_password2 = $model->getAttributeLabel('owner_password2'); ?>
							<?php echo $form->passwordField($model,'owner_password2',array('class'=>'textfield')); ?>
							<?php echo $form->error($model,'owner_password2'); ?>
						</div>
                       
						<?php if(CCaptcha::checkRequirements()): ?>
							<div class="row captcha">
								<p class="image">
									<?php $this->widget('CCaptcha'); ?>
									<?php if(strval($model->verifyCode) === '') $model->verifyCode = $model->getAttributeLabel('verifyCode'); ?>
									<?php echo $form->textField($model,'verifyCode',array('class'=>'textfield')); ?>
								</p>
								<?php echo $form->error($model,'verifyCode'); ?>
							</div>
							<div class="clear"></div>
						<?php endif; ?>
						  
                       <div class="row btns">
							<?php echo CHtml::label('&nbsp;',''); ?>
							<?php //echo CHtml::ajaxSubmitButton('Send', $this->createUrl('site/contact'), array('class'=>'btn2')); ?>
							<?php echo CHtml::link('Send', '#', array(
								'onclick'=>"registerSubmit(); return false;",
								'class'=>'btn2',
								'encode'=>false
							)); ?>
						</div>

					  </fieldset>
</div>
<?php $this->endWidget(); ?>
				</div>