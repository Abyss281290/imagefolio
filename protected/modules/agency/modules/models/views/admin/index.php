<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Talents'=>array('/agency/models/admin/index'),
	'Manage',
);

$this->title = 'Manage Talents';
if(isset($_REQUEST['agency_id']) && ($agency = Agencies::model()->findByPk($_REQUEST['agency_id']))) {
	$this->title .= ' ('.CHtml::encode($agency->full_name).')';
}
?>
<?php echo CHtml::link('Create Talent', array('admin/create'), array('class'=>'button blue', 'style'=>'margin-bottom:10px')); ?>
<?php echo PlansHelper::renderPlanInfo(); ?>
<?php
$this->renderPartial($view, array(
	'model'=>$model,
));
?>