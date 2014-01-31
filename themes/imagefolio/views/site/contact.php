<?php
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getTheme()->baseUrl.'/js/jquery.form-defaults.js');
?>
<script type="text/javascript">
function contactsSubmit()
{
	var form = $("#contacts #form1");
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
				$("#contacts_success").show(200, function() {
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
	$("#form1 :input").each(function(k,v) {
		var val = $(v).val();
		$(v).val('');
		$(v).DefaultValue(val);
	});
});
</script>
<div class="alpha grid_5 form">
	<h2><span class="red">contact</span> form</h2>
	<div id="contacts_success" class="notification success" style="display: none">
		<h5>Thank you for your message</h5>
	</div>
	<?php $form=$this->beginWidget('CActiveForm', array(
			'action'=>$this->createUrl('site/contact'),
			'id'=>'form1',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
		<div class="row">
			<?php if(strval($model->name) === '') $model->name = $model->getAttributeLabel('name'); ?>
			<?php echo $form->textField($model,'name',array('class'=>'textfield')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
		<div class="clear"></div>
		<?php /* <div class="row">
			<?php echo $form->labelEx($model,'agency_name'); ?>
			<?php echo $form->textField($model,'agency_name',array('class'=>'textfield')); ?>
			<?php echo $form->error($model,'agency_name'); ?>
		</div>
		<div class="clear"></div> */ ?>
		<div class="row">
			<?php if(strval($model->email) === '') $model->email = $model->getAttributeLabel('email'); ?>
			<?php echo $form->textField($model,'email',array('class'=>'textfield')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
		<div class="clear"></div>
		<div class="row">
			<?php if(strval($model->message) === '') $model->message = $model->getAttributeLabel('message'); ?>
			<?php echo $form->textArea($model,'message',array('class'=>'textarea')); ?>
			<?php echo $form->error($model,'message'); ?>
		</div>
		<div class="clear"></div>
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
		<?php /*if(CCaptcha::checkRequirements()): ?>
			<div class="row captcha">
				<?php echo $form->labelEx($model,'verifyCode'); ?>
				<div class="clear"></div>
				<p class="image">
					<?php $this->widget('CCaptcha'); ?>
					<?php echo $form->textField($model,'verifyCode',array('class'=>'textfield')); ?>
				</p>
				<?php echo $form->error($model,'verifyCode'); ?>
			</div>
			<div class="clear"></div>
			<?php endif;*/ ?>
		<div class="row btns">
			<?php echo CHtml::label('&nbsp;',''); ?>
			<?php //echo CHtml::ajaxSubmitButton('Send', $this->createUrl('site/contact'), array('class'=>'btn2')); ?>
			<?php echo CHtml::link('Send', '#', array(
				'onclick'=>"contactsSubmit(); return false;",
				'class'=>'btn2',
				'encode'=>false
			)); ?>
		</div>
		<div class="clear"></div>
		<span class="loading" style="display: none;">Please wait..</span>
		<div class="clear"></div>
	<?php $this->endWidget(); ?>
	<?php /*
	<form id="form1">
	  <div class="success"> Contact form submitted!<br>
		<strong>We will be in touch soon.</strong> </div>
	  <fieldset>
		<label class="name">
		  <input type="text" value="Name:">
		  <span class="error">*This is not a valid name.</span> <span class="empty">*This field is required.</span> </label>
		<label class="email">
		  <input type="email" value="E-mail:">
		  <span class="error">*This is not a valid email address.</span> <span class="empty">*This field is required.</span> </label>						
		<label class="message">
		  <textarea>Message:</textarea>
		  <span class="error">*The message is too short.</span> <span class="empty">*This field is required.</span> </label>
		<br class="clear">
		<div class="btns"><a href="#" class="btn2" data-type="reset">Clear</a><a href="#" class="btn2" data-type="submit">Send</a></div>
	  </fieldset>
	</form>
	*/ ?>
</div>
<div class="omega grid_10 prefix_1 border-left">
	<h2><span class="red">stay in</span> touch</h2>
	<dl class="img-box">

		<dl class="address">
				<dt class="h3">UK<br>
				14 Golders Green Cres<br>
				  London NW11 8LE</dt>
				<dd><span>Phone:</span><span class="red"> +44 (0) 20 3286 3270</span></dd>
			</dl>

		<dd>
			<dl class="address">
				<dt class="h3">Canada<br>
58 Waterloo Row<br>
Fredericton NB E3B 1Y9</dt>
				<dd><span>Phone:</span><span class="red">  +1 506 206 2756</span></dd>							</dl>
		</dd>
	</dl>
<h4><span class="red">ImageFolio</span> is a Product of <span class="red">Net Tech Engineering Ltd</span><br>
A Company Registered in the UK: No 3800658 & in Canada: No: 647548<br>
Microsoft Partner Number 529417</h4>
</div>