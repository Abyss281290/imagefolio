<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Talents'=>array('index'),
	$model->firstname.' '.$model->lastname=>array('admin/update/id/'.$model->id),
	'Video',
);

$this->title = 'Video';
?>

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
	
	<?php echo $form->errorSummary($model); ?>
	
	<?php if($model->video->exists): ?>
	<div class="row">
		<div class="video" id="video">
			<?php
			$this->widget('ext.videoPlayer.Player', array(
				'src' => $model->video->full,
				'width' => $this->module->videosSize[0],
				'height' => $this->module->videosSize[1],
			));
			?>
			<div>
				<?php echo CHtml::ajaxLink(
						CHtml::image(
							Yii::app()->request->baseUrl . '/images/trash.png',
							Yii::t('main', 'Remove video'),
							array('width'=>16, 'height'=>16, 'border'=>0, 'style'=>'vertical-align: middle')
						).'Remove video',
						$this->createUrl('admin/videoRemove', array('id'=>$model->id)),
						array('update'=>'#video'),
						array('class' => 'button small', 'confirm'=>'Remove video?')
					);
				?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'video'); ?>
		<?php echo $form->fileField($model, 'video'); ?> (<?php echo $this->module->videosAllowedTypes; ?>)
		<?php echo $form->error($model, 'video'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo $form->label($model,''); ?>
		<?php echo CHtml::submitButton('Upload', array('class' => 'button blue')); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo CHtml::link(Yii::t('main', 'Cancel'), $this->createUrl('index'), array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>