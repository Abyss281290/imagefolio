<?php
$type_ajax = array(
	'update' => '#characteristics',
	'url' => $this->createUrl('ajaxLoadCharacteristics'),
	'data' => "js:{request_id: ".intval($model->id).", type_id: $('#ModelsRequests_type_id').val()}",
	'cache' => false,
);
?>
<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'models-requests-form',
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
	<table>
		<tr>
			<td style="vertical-align: top">
				<div class="form">
					<div class="row">
						<?php echo $form->labelEx($model,'agency_id'); ?>
						<?php if(!Yii::app()->user->isAdmin()): ?>
							<?php echo $form->hiddenField($model, 'agency_id'); ?>
							<div style="padding: 6px 0; font-weight: bold"><?php echo CHtml::encode($model->agency->full_name); ?></div>
						<?php else: ?>
							<?php echo $form->dropDownList($model, 'agency_id', AgencyHelper::getAgenciesIdTitle(), array('empty'=>'- Not selected -')); ?>
							<?php echo $form->error($model, 'agency_id'); ?>
						<?php endif; ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'name'); ?>
						<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>255,'class'=>'textfield')); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'email'); ?>
						<?php echo $form->textField($model,'email',array('size'=>30,'maxlength'=>255,'class'=>'textfield')); ?>
						<?php echo $form->error($model,'email'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'birthday'); ?>
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

					<div class="row">
						<?php echo $form->labelEx($model,'telephone'); ?>
						<?php echo $form->textField($model,'telephone',array('size'=>30,'maxlength'=>255,'class'=>'textfield')); ?>
						<?php echo $form->error($model,'telephone'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'telephone2'); ?>
						<?php echo $form->textField($model,'telephone2',array('size'=>30,'maxlength'=>255,'class'=>'textfield')); ?>
						<?php echo $form->error($model,'telephone2'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'address'); ?>
						<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>30,'class'=>'textarea')); ?>
						<?php echo $form->error($model,'address'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'about'); ?>
						<?php echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>30,'class'=>'textarea')); ?>
						<?php echo $form->error($model,'about'); ?>
					</div>

					<?php /*
					<div class="row">
						<?php echo $form->labelEx($model,'image_head_shot'); ?>
						<?php echo $form->fileField($model,'image_head_shot',array('rows'=>6, 'cols'=>30)); ?>
						<div class="fileTypes">jpeg, jpg, png, gif, tif, bmp</div>
						<?php echo $form->error($model,'image_head_shot'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'image_mid_length'); ?>
						<?php echo $form->fileField($model,'image_mid_length',array('rows'=>6, 'cols'=>30)); ?>
						<div class="fileTypes">jpeg, jpg, png, gif, tif, bmp</div>
						<?php echo $form->error($model,'image_mid_length'); ?>
					</div>

					<div class="row">
						<?php echo $form->labelEx($model,'image_full_length'); ?>
						<?php echo $form->fileField($model,'image_full_length',array('rows'=>6, 'cols'=>30)); ?>
						<div class="fileTypes">jpeg, jpg, png, gif, tif, bmp</div>
						<?php echo $form->error($model,'image_full_length'); ?>
					</div>
				</div>
				*/ ?>
			</td>
			<td style="vertical-align: top; padding-left: 10px">
				<div class="form">
					<div class="row">
						<?php echo $form->labelEx($model,'type_id'); ?>
						<?php echo $form->dropDownList(
								$model,
								'type_id',
								CHtml::listData(AgencyTypes::model()->findAll('active=1'),'id','title'),
								array('empty'=>'- Not selected -', 'ajax'=>$type_ajax)
						); ?>
						<?php echo $form->error($model, 'type_id'); ?>
					</div>

					<div id="characteristics">
						<?php $this->renderPartial('_form_characteristics',array(
							'model'=>$model,
							'type'=> $model->type,
							//'type2'=> $model->type2,
						)); ?>
					</div>
				</div>
			</td>
		</tr>
	</table>
	
	<div class="row buttons">
		<?php echo CHtml::label('&nbsp;',''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button blue')); ?>
		<?php echo CHtml::link('Cancel', $this->createUrl('index'), array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>