<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'content-form',
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
	
	<?php /* <div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model, 'category_id', array(''=>'- '.T::_('Please select').' -')+ContentHelper::getCategoriesIdTitle()); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div> */ ?>
	
	<?php /* <div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model, 'active', array(1=>T::_('yes'), 0=>T::_('no'))); ?>
		<?php echo $form->error($model,'active'); ?>
	</div> */ ?>
	
	<?php /* <div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model, 'image'); ?>
		<?php echo $form->error($model,'image'); ?>
		<?php if($model->image): ?>
		<div class="image" id="image" style="padding: 5px 0 0 153px">
			<?php echo CHtml::image($model->image->src['full'], '', array('style' => 'max-height:200px; border: 1px solid #aaa; padding: 1px')); ?>
			<?php if($model->image->exists): ?>
			<br />
			<?php
				echo CHtml::ajaxLink(
					CHtml::image(
						Yii::app()->request->baseUrl . '/images/trash.png',
						Yii::t('main', 'Delete Image'),
						array('width'=>16, 'height'=>16, 'border'=>0)
					).ContentModule::t('Remove current image'),
					$this->createUrl('admin/imageRemove', array('id'=>$model->id)),
					array('update'=>'#image')
				);
			?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div> */ ?>
	<?php /*
	<?php if($model->created_by_obj): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $model->created_by_obj->username; ?>
		<br /><?php echo $model->created_time; ?>
	</div>
	<?php endif; ?>
	
	<?php if($model->updated_by_obj): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'updated'); ?>
		<?php echo $model->updated_by_obj->username; ?>
		<br /><?php echo $model->updated_time; ?>
	</div>
	<?php endif; ?>
	*/ ?>
	
	<?php /*
	<?php foreach(Yii::app()->params['languages'] as $lang => $langName): ?>
	<div class="clearfix grey-highlight">
		<p class="title"><?php echo $langName; ?></p>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title_'.$lang, array('class'=>'large')); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>
	<div class="row">
		<table style="width: auto">
			<tr>
				<td style="vertical-align: top"><?php echo $form->labelEx($model,'content'); ?></td>
				<td><?php $this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
			'model' => $model,
			'attribute' => 'content_'.$lang,
			'htmlOptions' => array(
			)
		)); ?>
		<?php echo $form->error($model,'active'); ?></td>
			</tr>
		</table>
	</div>
	<?php endforeach; ?>
	
	<div class="clearfix grey-highlight">
		<?php echo CHtml::label('', ''); ?>
	<?php foreach(Yii::app()->params['languages'] as $lang => $langName): ?>
		<p class="large title"><?php echo $langName; ?></p>
	<?php endforeach; ?>
	</div>
	*/ ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, 'title', array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<?php /* <div class="row">
		<table style="width: auto">
			<tr>
				<td style="vertical-align: top; width: 1px"><?php echo $form->labelEx($model,'short_content'); ?></td>
			<?php foreach(Yii::app()->params['languages'] as $lang => $langName): ?>
				<td style="vertical-align: top; width: 475px">
				<?php
					$menu = 'short_content'.($lang == $model->primaryLang()? '' : '_'.$lang);
					$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
						'model' => $model,
						'attribute' => $menu,
						'options' => array(
							'image_upload' => $this->createUrl('/imperavi/imageUpload')
						),
						'htmlOptions' => array(
							'style'=>'width:470px; height: 250px'
						)
					));
				?>
				<?php echo $form->error($model,$menu); ?></td>
			<?php endforeach; ?>
			</tr>
		</table>
	</div> */ ?>
	<div class="row">
		<table>
			<tr>
				<td style="vertical-align: top; width: 1px"><?php echo $form->labelEx($model,'content'); ?></td>
				<td>
				<?php
					$this->widget('application.extensions.imperavi.ImperaviRedactorWidget', array(
						'model' => $model,
						'attribute' => 'content',
						'options' => array(
							'imageUpload' => $this->createUrl('/imperavi/imageUpload')
						),
						'htmlOptions' => array(
							'class'=>'wysiwyg'
						)
					));
				?>
				<?php echo $form->error($model,$menu); ?></td>
			</tr>
		</table>
	</div>
	
	<div class="clearfix grey-highlight">
		<h2>Seo</h2>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'seo_title'); ?>
		<?php echo $form->textField($model, 'seo_title', array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'seo_title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'seo_keywords'); ?>
		<?php echo $form->textArea($model, 'seo_keywords',array('rows'=>6, 'cols'=>60)); ?>
		<?php echo $form->error($model,'seo_keywords'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'seo_description'); ?>
		<?php echo $form->textArea($model, 'seo_description',array('rows'=>6, 'cols'=>60)); ?>
		<?php echo $form->error($model,'seo_description'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo $form->label($model,''); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button blue')); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo CHtml::link(Yii::t('main', 'Cancel'), $this->createUrl('index'), array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->