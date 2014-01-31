<?php
Yii::app()->getClientScript()->registerCss('associations', '
	.row .associations {
		float: left;
	}
	.row .associations label {
		float: none !important;
		width: auto !important;
	}
');0999999999999
?>
<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agency-types-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('cols'=>60)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
	
	<div class="row">
		<?php
			$data = array();
			foreach(AgencyCharacteristics::model()->findAll(array('condition'=>'active=1','order'=>'`order`')) as $c)
				$data[$c->id] = CHtml::encode(($c->description === ''? $c->title : $c->description).' ('.(($t=CharacteristicsHelper::getElementTypes($c->type))? $t : $c->type).')');
		?>
		<?php echo $form->labelEx($model,'characteristics'); ?>
		<div class="associations">
			<?php echo CHtml::checkBoxList(CHtml::activeName($model,'characteristics'),CHtml::listData($model->characteristics,'id','id'),$data); ?>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->