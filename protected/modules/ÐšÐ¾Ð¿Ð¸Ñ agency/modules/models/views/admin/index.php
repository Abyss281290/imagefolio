<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Models'=>array('/agency/models/admin/index'),
	'Manage',
);

$this->title = 'Manage Models';

$this->renderPartial($view, array(
	'model'=>$model,
));
?>