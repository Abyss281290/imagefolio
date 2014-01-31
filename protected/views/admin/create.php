<?php
$this->breadcrumbs=array(
	'Users'=>array('admin'),
	'Create',
);

$this->title = 'Create User';

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>