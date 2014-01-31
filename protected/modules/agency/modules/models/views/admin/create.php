<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Talents'=>array('/agency/models/admin'),
	'Create',
);

$this->title = 'Create Talent';
?>
<?php if(AgencyModule::getAgency()->canAddModels() == false): ?>
	<?php Yii::app()->user->addFlashWarning('models_allowed_limit', 'Please upgrade your package to allow additional talent or delete existing talent to allow new talent upload.'); ?>
<?php else: ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php endif; ?>