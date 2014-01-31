<div class="form" style="border: none">
	<?php
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
		if($menu->parent_id == 0) {
			$menus1[] = array($menu->type->id, $menu->type->display_title);
			$menus2[$menu->id] = array();
		} else {
			$menus2[$menu->parent_id][] = array($menu->type->id, $menu->type->display_title);
		}
		$i++;
	}
	//echo '<pre>';
	//var_dump(count($menus));
	//print_r($menus1);
	//print_r($menus2);
	//echo '</pre>';
	?>
	<div id="agency-menus">
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
				<td style="height:20px">
					<div>
						<?php echo CHtml::button('&and;', array(
							'onclick'=>'AgencyMenu.move(-1)',
							'encode'=>false
						)); ?>
						<?php echo CHtml::button('&or;', array(
							'onclick'=>'AgencyMenu.move(1)',
							'encode'=>false
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
					foreach($menus2 as $items) {
						if($items):
					?>
					<select rel="menu2[<?php echo $i; ?>]">
						<?php foreach($items as $menu): ?>
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
	</div>
</div>