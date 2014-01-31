<?php
$geo = $this->widget('ext.geo.Geo', array(
	'names' => array(
		'countries' => 'country_code',
		'cities' => 'city_id'
	),
	'model' => $model
));
$geoSelects = $geo->dropDownLists();
?>
<div class="form" style="border: none">
	<div class="row">
		<?php echo $form->labelEx($model,'short_name'); ?>
		<?php echo $form->textField($model,'short_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'short_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_name'); ?>
		<?php echo $form->textField($model,'full_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'full_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telephone'); ?>
		<?php echo $form->textField($model,'telephone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'telephone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->textField($model,'website',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'website'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'owner_login'); ?>
		<?php echo $form->textField($model,'owner_login',array('size'=>60,'maxlength'=>255,'autocomplete'=>'off')); ?>
		<?php echo $form->error($model,'owner_login'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'owner_password'); ?>
		<?php echo $form->passwordField($model,'owner_password',array('size'=>60,'maxlength'=>255,'autocomplete'=>'off')); ?>
		<?php echo $form->error($model,'owner_password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'owner_password2'); ?>
		<?php echo $form->passwordField($model,'owner_password2',array('size'=>60,'maxlength'=>255,'autocomplete'=>'off')); ?>
		<?php echo $form->error($model,'owner_password2'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'owner_name'); ?>
		<?php echo $form->textField($model,'owner_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'owner_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'owner_email'); ?>
		<?php echo $form->textField($model,'owner_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'owner_email'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'country_code'); ?>
		<?php echo $geoSelects['countries'];//$form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country_code'); ?>
	</div>

	<?php /*<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $geoSelects['cities'];//$form->textField($model,'city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div> */ ?>

	<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model, 'active', array(1=>T::_('yes'), 0=>T::_('no'))); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>
	*/ ?>

	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?> (jpg, jpeg, gif, png) (Max Size: <?php echo $this->module->logoResize['width'].'x'.$this->module->logoResize['height']; ?> px)
		<?php echo $form->error($model,'image'); ?>
		<?php if($model->image): ?>
		<div class="image" id="image" style="padding: 5px 0 0 153px">
			<?php echo CHtml::image($model->image->full, '', array('style' => 'border: 1px solid #aaa; padding: 1px')); ?>
			<?php if($model->image->exists): ?>
			<div>
				<?php echo CHtml::ajaxLink(
						CHtml::image(
							Yii::app()->request->baseUrl . '/images/trash.png',
							Yii::t('main', 'Delete Image'),
							array('width'=>16, 'height'=>16, 'border'=>0)
						).'Remove current logo',
						$this->createUrl('admin/imageRemove', array('id'=>$model->id)),
						array('update'=>'#image')
					);
				?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	
	<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'banner'); ?>
		<?php echo $form->fileField($model,'banner'); ?> (jpg, jpeg, gif, png) (Size: <?php echo $this->module->bannerResize['width'].'x'.$this->module->bannerResize['height']; ?>)
		<?php echo $form->error($model,'banner'); ?>
		<?php if($model->banner): ?>
		<div class="banner" id="banner" style="padding: 5px 0 0 153px">
			<?php echo CHtml::image($model->banner->full, '', array('style' => 'border: 1px solid #aaa; padding: 1px')); ?>
			<?php if($model->banner->exists): ?>
			<div>
				<?php echo CHtml::ajaxLink(
						CHtml::image(
							Yii::app()->request->baseUrl . '/images/trash.png',
							Yii::t('main', 'Delete banner'),
							array('width'=>16, 'height'=>16, 'border'=>0)
						).'Remove current banner',
						$this->createUrl('admin/bannerRemove', array('id'=>$model->id)),
						array('update'=>'#banner')
					);
				?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'splash'); ?>
		<?php echo $form->fileField($model,'splash'); ?> (jpg, jpeg, gif, png, swf)
		<?php echo $form->error($model,'splash'); ?>
		<?php if($model->splash): ?>
		<div class="splash" id="splash" style="padding: 5px 0 0 153px">
			<?php if($model->splash->exists): ?>
			<?php echo CHtml::link(
				'Check it on the front-end',
				$this->createUrl('/agency/agencies/default/splash', array('id'=>$model->id)),
				array(
					'class'=>'button',
					'target'=>'_blank',
					'style'=>'margin-bottom: 5px'
				)
			); ?>
			<div>
				<?php echo CHtml::ajaxLink(
						CHtml::image(
							Yii::app()->request->baseUrl . '/images/trash.png',
							Yii::t('main', 'Delete splash'),
							array('width'=>16, 'height'=>16, 'border'=>0)
						).'Remove current splash',
						$this->createUrl('admin/splashRemove', array('id'=>$model->id)),
						array('update'=>'#splash')
					);
				?>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	*/ ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'layout'); ?>
		<table style="width: auto; float: left">
			<tr style="background: none">
		<?php foreach(AgenciesHelper::getPageLayouts() as $k => $v): ?>
			<td style="vertical-align: top; padding-right: 10px">
				<fieldset>
					<legend>
						<?php echo $form->radioButton($model, 'layout', array('value'=>$k, 'uncheckValue'=>NULL)); ?>
						<small><?php echo CHtml::encode($v->title); ?></small>
					</legend>
					<div><?php echo CHtml::image($v->image); ?></div>
				</fieldset>
			</td>
		<?php endforeach; ?>
			</tr>
		</table>
		<div style="width: 300px; padding-top: 25px; float: left">
			Please select the layout you would like your talents portfolio's to display as, from the 2 options on the left, the Horizontal option suits those agencies that like to display landscape images regularly, option 1 has proved to be more popular with your clients, you can choose to change this option at any time.
		</div>
		<?php echo $form->error($model,'layout'); ?>
		<div class="clear"></div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'color_site'); ?>
		<?php echo $form->dropDownList($model, 'color_site', AgenciesHelper::getThemeColorsForDropDownList()); ?>
		<?php echo $form->error($model,'color_site'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'color_menu'); ?>
		<?php echo $form->dropDownList($model, 'color_menu', AgenciesHelper::getThemeColorsForDropDownList()); ?>
		<?php echo $form->error($model,'color_menu'); ?>
	</div>
	
	<?php if(Yii::app()->user->isAdmin()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'confirmed'); ?>
		<?php echo $form->dropDownList($model, 'confirmed', array(1=>T::_('yes'), 0=>T::_('no'))); ?>
		<?php echo $form->error($model,'confirmed'); ?>
	</div>
	<?php endif; ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'google_analytics_account'); ?>
		<?php echo $form->textField($model,'google_analytics_account',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'google_analytics_account'); ?>
	</div>
	
	<?php if(!$model->isNewRecord): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'date_registered'); ?>
		<?php echo CHtml::encode($model->date_registered); ?>
	</div>
	<div class="row">
		<?php echo CHtml::label('Preview', ''); ?>
		<?php echo CHtml::link(
			$url = $this->createAbsoluteUrl('/agency/agencies/default/view', array('id'=>$model->id)),
			$url,
			array('target'=>'_blank')
		); ?>
	</div>
	<?php endif; ?>
	<div class="clear"></div>

</div><!-- form -->