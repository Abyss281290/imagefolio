<?php
$this->title = $model->full_name;
?>
<?php echo CHtml::link('<span>Skip</span>', $this->createUrl('splash', array('id'=>$model->id, 'skip'=>1)), array('class'=>'button agency-splash-skip')); ?>
<div class="clear"></div>
<?php
switch($model->splash->type)
{
	case 'image':
		echo CHtml::image($model->splash->full);
		break;
	case 'flash':
		$this->widget('application.extensions.flash.EJqueryFlash',
			array(
				'name'=>'agency-splash',
				//'text'=>'You must install Flash Player first',
				'htmlOptions'=>array(
					'src'=>$model->splash->full
				)
			)
		);
		break;
}
?>