<?php
// we have $model var here with registered agency
$this->title = 'Thank you for your registration';
$this->pageTitle = 'Thank you for your registration';

Yii::app()->clientScript->registerCssFile($this->module->assetPath.'/css/front/register.css');
?>
<div class="agency-register-done">
	Please confirm your registration by clicking on the link that has now been sent to you by email.
</div>