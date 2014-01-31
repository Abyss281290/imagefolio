<?php
if(!$model)
	$model = AgencyCharacteristics::model();

$view = 'element_data/'.$selectedType;
?>
<?php if($this->getViewFile($view)): ?>
<div class="row">
	<fieldset>
		<legend><?php echo CHtml::encode(CharacteristicsHelper::getElementTypes($selectedType)); ?> data</legend>
		<?php $this->renderPartial($view, array('selectedType'=>$selectedType,'model'=>$model)); ?>
	</fieldset>
</div>
<?php endif; ?>
