<?php
// we have $model var here with registered agency
?>
<h2 style="font-family: sans-serif">Thank you for your registration</h2>
<fieldset style="font-family: sans-serif; margin-bottom: 10px"><legend style="font-family: sans-serif">For your records your credentials are</legend>
	<table>
		<tr>
			<th style="font-family: sans-serif; text-align: right; padding-bottom: 10px"><?php echo 'Login';//$model->getAttributeLabel('owner_login'); ?></th>
			<td style="font-family: sans-serif; text-align: left; padding-bottom: 10px"><?php echo CHtml::encode($model->owner_login); ?></td>
		</tr>
		<tr>
			<th style="font-family: sans-serif; text-align: right"><?php echo 'Password';//$model->getAttributeLabel('owner_password'); ?></th>
			<td style="font-family: sans-serif; text-align: left"><?php echo CHtml::encode($model->owner_password); ?></td>
		</tr>
		<?php /*<tr>
			<th style="font-family: sans-serif; text-align: right">Login page</th>
			<td style="font-family: sans-serif; text-align: left"><?php echo CHtml::link($this->createAbsoluteUrl('/site/login'), $this->createAbsoluteUrl('/site/login')); ?></td>
		</tr>*/ ?>
	</table>
</fieldset>
<strong style="font-family: sans-serif">To start, please confirm your registration by clicking this link (or copy into your browser if you are having problems):</strong>
<div style="font-family: sans-serif"><?php echo CHtml::link($model->getConfirmationUrl(),$model->getConfirmationUrl()); ?></div>
<div style="font-family: sans-serif; margin-top: 20px">if you did not request an account with ImageFolio, please ignore this email, you will not be contacted again.</div>
<div style="margin: 20px 0">On future visits you can log in here <?php echo CHtml::link($this->createAbsoluteUrl('/site/login'), $this->createAbsoluteUrl('/site/login')); ?></div>
<div>Looking forward to a long and mutually beneficial relationship, please do not hesitate contacting us if you have any issues.</div>
	<div style="margin-top: 20px">
		Kindest regards,
		<div style="font-style: italic"><?php echo CHtml::link(Yii::app()->name, Yii::app()->request->hostInfo.Yii::app()->homeUrl); ?></div>
	</div>
</div>