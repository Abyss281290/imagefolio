<div class="form">
	<?php echo CHtml::form('', 'post', array('id'=>'create-package-form')); ?>
	<div class="row">
		<?php echo CHtml::label('New package','new_title'); ?>
		<?php echo CHtml::textField('new_title', '', array('size'=>60)); ?>
	</div>
	<?php if($data = ModelsPackagesHelper::getListData()): ?>
	<div class="row">
		<?php echo CHtml::label('Add to existent','extend'); ?>
		<?php echo CHtml::dropDownList('extend', '', $data, array('empty'=>'- select package -')); ?>
	</div>
	<?php endif; ?>
	<div class="row buttons">
		<?php echo CHtml::label('',''); ?>
		<?php echo CHtml::submitButton('Confirm',array('class'=>'button blue')); ?>
		<?php echo CHtml::image(Yii::app()->baseUrl.'/'.Yii::app()->params['ajaxLoader'],'',array('class'=>'loader','style'=>'display:none')); ?>
	</div>
	<?php echo CHtml::endForm(); ?>
</div>