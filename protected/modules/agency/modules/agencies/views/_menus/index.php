<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Menu',
);

$this->title = 'Agency Menu';
/////////////

//Yii::app()->getClientScript()->registerCssFile($this->module->assetPath.'/css/agency_menus.css');
Yii::app()->getClientScript()->registerCoreScript('jquery');
Yii::app()->getClientScript()->registerScriptFile($this->module->assetPath.'/js/agency_menus.js');
Yii::app()->getClientScript()->registerCssFile($this->module->assetPath.'/css/agency_menus.css');

$typesModels = AgencyTypes::model()->findAll('active=1');
$typesListData = array();
foreach($typesModels as $type) {
	$typesListData[$type->id] = $type->display_title;
}
$menus1 = array();
$menus2 = array();
$i = 0;
foreach($menus as $menu) {
	if($menu->parent_id > 0 && !isset($menus2[$menu->parent_id]))
		$menus2[$menu->parent_id] = array();
	if($menu->parent_id == 0)
		$menus1[] = array($menu->type->id, $menu->type->display_title);
	else
		$menus2[$menu->parent_id][] = array($menu->type->id, $menu->type->display_title);
	$i++;
}
/*echo '<pre>';
var_dump(count($menus));
print_r($menus1);
print_r($menus2);
echo '</pre>';*/
?>
<div id="agency-menus">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agency-menus-form',
	'enableAjaxValidation'=>false,
)); ?>
<table style="width:auto">
	<tr>
		<th>Types list</th>
		<th></th>
		<th>First level menu</th>
		<th>Second level menu</th>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
			<div>
				<?php echo CHtml::button('∧', array(
					'onclick'=>'AgencyMenu.move(-1)',
				)); ?>
				<?php echo CHtml::button('∨', array(
					'onclick'=>'AgencyMenu.move(1)',
				)); ?>
			</div>
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="list source">
			<?php if($typesListData): ?>
            <?php echo CHtml::dropDownList('firstSelect', null, $typesListData, array(
				'multiple'=>true,
			)); ?>
            <?php endif; ?>
		</td>
		<td class="buttons">
			<div>
				<?php echo CHtml::button('>', array(
					'onclick'=>'AgencyMenu.add()',
				)); ?>
			</div>
			<div><?php echo CHtml::button('<', array(
					'onclick'=>'AgencyMenu.remove()',
				)); ?>
			</div>
		</td>
		<td class="list destination">
			<select rel="menu" id="secondSelect">
				<?php foreach($menus1 as $menu): ?>
				<option value="<?php echo $menu[0]; ?>"><?php echo CHtml::encode($menu[1]); ?></option>
				<?php endforeach; ?>
			</select>
		</td>
		<td class="list" id="agency-menus-submenus">
			<?php
			$i = 0;
			foreach($menus2 as $menus2) {
				if($menus2):
			?>
			<select rel="menu2[<?php echo $i; ?>]">
				<?php foreach($menus2 as $menu): ?>
				<option value="<?php echo $menu[0]; ?>"><?php echo CHtml::encode($menu[1]); ?></option>
				<?php endforeach; ?>
			</select>
			<?php
				endif;
				$i++;
			}
			?>
		</td>
	</tr>
</table>
<hr />
<?php echo CHtml::submitButton('Save', array('class'=>'button blue')); ?>
<?php $this->endWidget(); ?>
</div>