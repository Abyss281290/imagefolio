<div id="agency-plan-info">
You are currently subscribed to package <?php echo CHtml::encode($agency->plan->title); ?> 
which allows <?php echo $agency->plan->models_allowed; ?> talents, 
you currently have <?php echo $agency->models_count; ?> talents on the system, 
to upgrade <?php echo CHtml::link('click here', Yii::app()->createUrl('/agency/agencies/plans/select')); ?>
</div>