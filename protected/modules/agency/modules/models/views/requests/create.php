<?php
$this->title = 'Submit Application';

$css = <<<CSS
#maincontactform .textfield,
#maincontactform .textarea {
	width: 430px !important;
}
#maincontactform input.hasDatepicker {
	width: 200px !important;
}

.block {
	margin-bottom: 10px;
}
.block .content {
	background: #FAFAFA;
	border: 1px solid #EEEEEE;
	padding: 15px;
}
.block.images table {
	width: 100%;
}
.block td {
	vertical-align: top;
}
.block .row {
	width: auto !important;
}
.block.type .row.type {
	width: auto !important;
	margin-top: 10px !important;
	white-space: nowrap !important;
}
#maincontactform .block.type .row.type label {
	width: 50px !important;
	min-width: 50px !important;
	display: inline-block;
}
#maincontactform .block.type .row.type .combo {
	float: none;
	display: inline-block;
}
#maincontactform #characteristics th,
#maincontactform #characteristics td {
	padding-bottom: 5px;
}
#maincontactform #characteristics th {
	width: 1px;
	white-space: nowrap;
	font-weight: bold;
	font-size: 11px;
	padding-right: 5px;
	padding-top: 3px;
}
#maincontactform #characteristics fieldset {
}

.files {
	list-style: decimal;
}
.files img.indicator {
	vertical-align: middle;
	margin-right: 5px;
	display: none;
}
.files a.crop {
	margin-left: 5px;
}
.files img.thumb {
	display: block;
	border: 1px solid #ccc;
	padding: 1px;
}
.files .remove {
	display: inline-block;
	margin-right: 5px;
}
.files .remove img {
	vertical-align: middle;
}
#maincontactform a.button {
	text-transform: uppercase;
	color: #fff;
	font-weight: bold;
}
#maincontactform a.button span {
}

#characteristics th,
#characteristics td {
	vertical-align: top;
	text-align: left;
}
#characteristics th {
}
#characteristics td {
	padding-right: 10px;
	width: 100%;
}
CSS;
Yii::app()->clientScript->registerCss('become-model', $css);
Yii::app()->clientScript->registerScriptFile($this->module->assetPath.'/js/become-model.js');
Yii::app()->clientScript->registerScript('become-model', 'BecomeModel.urls = '.CJSON::encode(array(
	'viewCropTempFile'=>$this->createUrl('viewCropTempFile')
)));
$this->widget('ext.colorbox.JColorBox');
?>
<style type="text/css">
</style>
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
	<div class="block data">
		<h3>Personal Info</h3>
		<div class="content">
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
					</td>
					<td>
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
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="block type">
		<h3>Type info</h3>
		<div class="content">
			<table>
				<tr>
					<td style="white-space: nowrap">
						<div class="row type">
							<?php echo $form->labelEx($model,'type_id'); ?>
							<div style="margin-bottom: 5px; margin-left: 50px">please select the talent type that best describes you and complete</div>
							<div style="clear:left; margin-left: 50px">
								<?php echo $form->dropDownList(
										$model,
										'type_id',
										CHtml::listData($agencyParentMenuTypes,'type.id','type.title'),
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
							</div>
							<?php echo $form->error($model, 'type_id'); ?>
						</div>
						<div class="clear"></div>
					</td>
					<td>
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
		</div>
	</div>
	
	<div class="block captcha">
		<div class="content">
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
		</div>
	</div>
	
	<?php /* storage of textfields with names of uploaded files */ ?>
	<div id="uploaded_files"></div>
	
<?php $this->endWidget(); ?>
	<div class="block images">
		<h3>Images</h3>
		<div class="content">
			<div class="files">
				<table>
					<tr>
						<td>
							<div class="row">
								<?php echo $form->labelEx($model,'image_head_shot'); ?>
								<div class="clear"></div>
								<?php echo CHtml::beginForm($this->createUrl('uploadTempImage'), 'post', array(
									'enctype' => 'multipart/form-data',
								)); ?>
								<?php echo $form->fileField($model,'image_head_shot',array('rows'=>6, 'cols'=>50)); ?>
								<?php echo CHtml::image(Yii::app()->baseUrl.'/images/loading1.gif','',array('class'=>'indicator','style'=>'display:none')); ?>
								<?php echo CHtml::endForm(); ?>
								<div class="fileTypes" style="clear: left">jpeg, jpg, png, gif</div>
								<?php echo $form->error($model,'image_head_shot'); ?>
							</div>
							<div class="clear"></div>
						</td>
						<td>
							<div class="row">
								<?php echo $form->labelEx($model,'image_mid_length'); ?>
								<div class="clear"></div>
								<?php echo CHtml::beginForm($this->createUrl('uploadTempImage'), 'post', array(
									'enctype' => 'multipart/form-data',
								)); ?>
								<?php echo $form->fileField($model,'image_mid_length',array('rows'=>6, 'cols'=>50)); ?>
								<?php echo CHtml::image(Yii::app()->baseUrl.'/images/loading1.gif','',array('class'=>'indicator','style'=>'display:none')); ?>
								<?php echo CHtml::endForm(); ?>
								<div class="fileTypes" style="clear: left">jpeg, jpg, png, gif</div>
								<?php echo $form->error($model,'image_mid_length'); ?>
							</div>
							<div class="clear"></div>
						</td>
						<td>
							<div class="row">
								<?php echo $form->labelEx($model,'image_full_length'); ?>
								<div class="clear"></div>
								<?php echo CHtml::beginForm($this->createUrl('uploadTempImage'), 'post', array(
									'enctype' => 'multipart/form-data',
								)); ?>
								<?php echo $form->fileField($model,'image_full_length',array('rows'=>6, 'cols'=>50)); ?>
								<?php echo CHtml::image(Yii::app()->baseUrl.'/images/loading1.gif','',array('class'=>'indicator','style'=>'display:none')); ?>
								<?php echo CHtml::endForm(); ?>
								<div class="fileTypes" style="clear: left">jpeg, jpg, png, gif</div>
								<?php echo $form->error($model,'image_full_length'); ?>
							</div>
							<div class="clear"></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	
	<div class="row buttons">
			<?php echo CHtml::linkButton('<span>Submit Application</span>', array('class'=>'button','onclick'=>'jQuery("#models-requests-form").submit(); return false')); ?>
	</div>

</div><!-- form -->