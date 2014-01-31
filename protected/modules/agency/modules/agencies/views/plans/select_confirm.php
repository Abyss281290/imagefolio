<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Payment Packages'=>array('select'),
	'Confirm Order'
);
$this->title = 'Confirm Order';

foreach(array(
	'Current package' => $currentPlan,
	'Selected package' => $selectedPlan
) as $title => $planModel):
	if(!$planModel)
		continue;
?>
<h2><?php echo CHtml::encode($title); ?></h2>
<?php
	$this->widget('ext.grid.GridView', array(
		'id'=>'agency-plans-grid-'.$planModel->id,
		'dataProvider'=>new CActiveDataProvider($planModel, array(
			'criteria'=>array(
				'condition'=>'id=:id',
				'params'=>array(':id'=>$planModel->id),
			),
			'sort'=>false,
			'pagination'=>false
		)),
		'template'=>'{items}',
		'rowCssClassExpression'=>'$this->rowCssClass[$row % count($this->rowCssClass)].($data->id == '.$agency->plan_id.'? " active" : "")',
		//'filter'=>$model,
		'columns'=>array(
			array(
				'name'=>'title',
				'htmlOptions'=>array('class'=>'bold nowrap', 'width'=>'25%')
			),
			array(
				'name'=>'models_allowed',
				'htmlOptions'=>array('width'=>'15%')
			),
			array(
				'name'=>'price',
				'value'=>'"$".number_format($data->price,2)',
				'htmlOptions'=>array('width'=>'15%')
			),
			array(
				'name'=>'website',
				'type'=>'booleanTick',
				'htmlOptions'=>array('class'=>'center')
			),
			array(
				'name'=>'packages',
				'type'=>'booleanTick',
				'htmlOptions'=>array('class'=>'center')
			),
			array(
				'name'=>'submissions',
				'type'=>'booleanTick',
				'htmlOptions'=>array('class'=>'center')
			),
			array(
				'name'=>'images_allowed',
				'htmlOptions'=>array('width'=>'15%')
			),
			array(
				'name'=>'id',
				'htmlOptions'=>array('width'=>'15%')
			)
		),
	));
endforeach;

echo CHtml::link('Confirm', array('processSelection','plan_id'=>$selectedPlan->id), array('class'=>'button blue','style'=>'margin-right: 5px'));
echo CHtml::link('Cancel', array('select'), array('class'=>'button'));
?>