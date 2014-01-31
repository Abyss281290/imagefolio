<p>
	<?php echo CHtml::image(Yii::app()->request->hostInfo.$package->agency->image->full); ?>
	<br /><br />
	Dear {client_name},<br /><br /><br /><br />
	I have prepared the attached package for you,<br /><br />
	<?php echo CHtml::link('{package_url}', '{package_url}', array('target'=>'_blank')); ?><br /><br />
	If this does not open as expected, please copy the link into a browser,<br /><br /><br /><br />
	<?php echo Yii::app()->user->fullname; ?><br /><br />
	<?php echo CHtml::encode($package->agency->address); ?><br /><br />
	<?php echo CHtml::encode($package->agency->telephone); ?>
</p>