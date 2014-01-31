<?php
$this->breadcrumbs=array(
	$this->module->id,
);
$this->title = 'Contact';
?>
<div id="maincontent" style="width:400px;">
	<div id="maincontactform">
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'contact-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
			<div class="row">
				<?php echo $form->labelEx($model,'name'); ?>
				<?php echo $form->textField($model,'name',array('class'=>'textfield')); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>
			<div class="clear"></div>
			<div class="row">
				<?php echo $form->labelEx($model,'agency_name'); ?>
				<?php echo $form->textField($model,'agency_name',array('class'=>'textfield')); ?>
				<?php echo $form->error($model,'agency_name'); ?>
			</div>
			<div class="clear"></div>
			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('class'=>'textfield')); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
			<div class="clear"></div>
			<div class="row">
				<?php echo $form->labelEx($model,'message'); ?>
				<?php echo $form->textArea($model,'message',array('class'=>'textarea')); ?>
				<?php echo $form->error($model,'message'); ?>
			</div>
			<div class="clear"></div>
			<?php if(CCaptcha::checkRequirements()): ?>
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
				<?php endif; ?>
			<div class="row buttons">
				<?php echo CHtml::label('&nbsp;',''); ?>
				<?php echo CHtml::submitButton('Send request', array('class'=>'buttoncontact')); ?>
			</div>
			<div class="clear"></div>
			<span class="loading" style="display: none;">Please wait..</span>
			<div class="clear"></div>
		<?php $this->endWidget(); ?>
	</div>
</div>

<div id="sidebar_contact">
      <!-- Detail Information Start //-->
      <div class="sidebox">
      
      <div class="contact_img">
  <img src="<?php echo Yii::app()->baseUrl; ?>/images/contact_1.jpg" alt="" width="114" height="81" />
  TeleHouse Data Centre London
  </div>
      
      <div class="contact_img">
  <img src="<?php echo Yii::app()->baseUrl; ?>/images/contact_2.jpg" alt="" width="114" height="81" />
 Net Tech Head Office Canada
  </div>
      
      <div class="contact_img">
  <img src="<?php echo Yii::app()->baseUrl; ?>/images/contact_3.jpg" alt="" width="114" height="81" />
  TeleHouse Data Centre London
  </div>
                   
<div class="clear"></div>

<div class="leftcol">
<p>Sales & Support</p>

<p>UK Tel: +44 (0)20 3286 3269<br>

CA Tel: +1 506 206 2756</p>

 

<p>Accounts: +44 (0)20 3286 3270</p>

 

<p>Email:<a href="mailto:info@net-tech.co.uk"> info@net-tech.co.uk</a></p>

</div>
<div class="rightcol">

<p>Company Registered Addresses</p>

 

<p>UK: Net Tech Engineering Limited<br/ >

14 Golders Green Crescent<br/ >

London NW11 8LE</p>

 

<p>CA: Net Tech Engineering Limited<br/ >

58 Waterloo Row<br/ >

Fredericton NB, E3B 1Y9</p>

 

<p>Registered in the UK: 3800658<br/ >

Registered in CA: 647548<br/ >

Microsoft Partner Number 529417</p>


</div>
     <div class="clear"></div>
      </div>
      <!-- Detail Information End //-->
    </div>