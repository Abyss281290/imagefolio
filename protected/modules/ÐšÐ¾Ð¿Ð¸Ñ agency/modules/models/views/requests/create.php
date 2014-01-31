<?php
$this->title = 'Become model';

$css = <<<CSS
#maincontactform .textfield,
#maincontactform .textarea {
	width: 220px !important;
}
#maincontactform input.hasDatepicker {
	width: 200px !important;
}
CSS;
Yii::app()->clientScript->registerCss('become-model', $css);
?>
<div id="maincontactform">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'models-requests-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation' => true,
		'clientOptions'=>array(
			'validateOnSubmit' => true,
			'validateOnChange' => true,
			'validateOnType' => false,
			'inputContainer' => 'div.row',
		),
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),
	)); ?>
	
	<?php echo $form->errorSummary($model); ?>
	<table>
		<tr>
			<td style="vertical-align:top">
				<div class="row">
					<?php echo $form->labelEx($model,'name'); ?>
					<div class="clear"></div>
					<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>'textfield')); ?>
					<?php echo $form->error($model,'name'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'email'); ?>
					<div class="clear"></div>
					<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>'textfield')); ?>
					<?php echo $form->error($model,'email'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'birthday'); ?>
					<div class="clear"></div>
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'birthday',
						'options'=>array(
							'showAnim'=>'fold',
							'changeMonth'=>true,
							'changeYear'=>true,
							'yearRange'=>'c-100:c+0'
						),
						'htmlOptions'=>array('class'=>'textfield'),
					));
					?>
					<?php echo $form->error($model,'birthday'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'telephone'); ?>
					<div class="clear"></div>
					<?php echo $form->textField($model,'telephone',array('size'=>60,'maxlength'=>255,'class'=>'textfield')); ?>
					<?php echo $form->error($model,'telephone'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'telephone2'); ?>
					<div class="clear"></div>
					<?php echo $form->textField($model,'telephone2',array('size'=>60,'maxlength'=>255,'class'=>'textfield')); ?>
					<?php echo $form->error($model,'telephone2'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'address'); ?>
					<div class="clear"></div>
					<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50,'class'=>'textarea')); ?>
					<?php echo $form->error($model,'address'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'about'); ?>
					<div class="clear"></div>
					<?php echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50,'class'=>'textarea')); ?>
					<?php echo $form->error($model,'about'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'image_head_shot'); ?>
					<div class="clear"></div>
					<?php echo $form->fileField($model,'image_head_shot',array('rows'=>6, 'cols'=>50)); ?>
					<div class="fileTypes" style="clear: left">jpeg, jpg, png, gif, tif, bmp</div>
					<?php echo $form->error($model,'image_head_shot'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'image_mid_length'); ?>
					<div class="clear"></div>
					<?php echo $form->fileField($model,'image_mid_length',array('rows'=>6, 'cols'=>50)); ?>
					<div class="fileTypes" style="clear: left">jpeg, jpg, png, gif, tif, bmp</div>
					<?php echo $form->error($model,'image_mid_length'); ?>
				</div>
				<div class="clear"></div>
				<div class="row">
					<?php echo $form->labelEx($model,'image_full_length'); ?>
					<div class="clear"></div>
					<?php echo $form->fileField($model,'image_full_length',array('rows'=>6, 'cols'=>50)); ?>
					<div class="fileTypes" style="clear: left">jpeg, jpg, png, gif, tif, bmp</div>
					<?php echo $form->error($model,'image_full_length'); ?>
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
			</td>
			<td style="vertical-align:top; width: 600px; padding-left: 20px">
				<div class="row">
					<?php echo $form->labelEx($model,'type_id'); ?>
					<?php echo $form->dropDownList(
							$model,
							'type_id',
							CHtml::listData(AgencyTypes::model()->findAll('active=1'),'id','title'),
							array(
								'empty'=>'- Not selected -',
								'ajax'=>array(
									'update' => '#characteristics',
									'url' => $this->createUrl('ajaxLoadCharacteristics'),
									'data' => "js:{request_id: ".intval($model->id).", type_id: $('#ModelsRequests_type_id').val()}",
									'cache' => false,
								),
								'onchange'=>'$("#characteristics").html("<img src=\"'.Yii::app()->baseUrl.'/'.Yii::app()->params['ajaxLoader'].'\">")',
								'autocomplete'=>'off'
							)
					); ?>
					<?php echo $form->error($model, 'type_id'); ?>
				</div>
				<div class="clear"></div>
				<div id="characteristics">
					<?php $this->renderPartial('create_characteristics',array(
						'model'=>$model,
						'type'=> $model->type,
						//'type2'=> $model->type2,
					)); ?>
				</div>
				<div class="clear"></div>
			</td>
		</tr>
	</table>
	<div class="row buttons">
		<?php echo CHtml::label('&nbsp;',''); ?>
		<?php echo CHtml::submitButton('Send request', array('class'=>'buttoncontact')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->