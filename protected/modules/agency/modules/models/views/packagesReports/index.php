<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Packages'=>array('adminPackages/index'),
	'Reports'
);

$this->title = 'Packages Reports';
?>

<?php /* <p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> */ ?>

<?php
$columns = array(
	array(
		'class'=>'ButtonColumn',
		'header'=>'Action',
		'template'=>'{delete}',
	),
	'package.title',
);
$user = Yii::app()->user;
if(!$user->isBooker()) {
	$filter = array();
	
	if($user->isAgency())
		$filter = array_merge(array('agency:'.$user->agency_id => 'Only my reports'), $filter);
	
	if($user->isAdmin()) {
		// agencies
		$conditions = array('and','sender_role=:role');
		$params = array(':role'=>'agency');
		if($user->isAgency()) {
			$conditions[] = 'agency_id=:agency_id';
			$params[':agency_id'] = $user->agency_id;
		}
		$items = Agencies::model()->findAllByPk(
			Yii::app()->db->createCommand()
				->selectDistinct('sender_user_id')
				->from('{{agency_models_packages_reports}}')
				->where($conditions, $params)->queryColumn()
		);
		$itemsFilter = array();
		foreach($items as $item)
			$itemsFilter['agency:'.$item->id] = $item->full_name;
		$filter = array_merge($filter, array('Agencies'=>$itemsFilter));
	}
	
	// bookers
	$conditions = array('and','sender_role=:role');
	$params = array(':role'=>'booker');
	if($user->isAgency()) {
		$conditions[] = 'agency_id=:agency_id';
		$params[':agency_id'] = $user->agency_id;
	}
	$items = AgencyBookers::model()->findAllByPk(
		Yii::app()->db->createCommand()
			->selectDistinct('sender_user_id')
			->from('{{agency_models_packages_reports}}')
			->where($conditions, $params)->queryColumn()
	);
	$itemsFilter = array();
	foreach($items as $item)
		$itemsFilter['booker:'.$item->id] = $item->fullname;
	$filter = array_merge($filter, array('Bookers'=>$itemsFilter));
	
	$columns = array_merge($columns, array(
		array(
			'header'=>'Sender',
			'name'=>'sender_filter',
			'value'=>'AgencyModule::getUserFullName($data->sender_role, $data->sender_user_id)',
			'filter'=>$filter
		)
	));
}
$columns = array_merge($columns, array(
	'recipient_name',
	'recipient_email',
	array(
		'name'=>'package_views',
		'value'=>'$data->package->views',
		//'filter'=>CHtml::activeTextField($model, 'package_views')
	),
	'package.last_viewed_time',
	'id',
));
$this->widget('ext.grid.GridView', array(
	'id'=>'models-packages-reports-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>$columns,
));
?>