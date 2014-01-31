<?php
if($model->scenario == 'insert')
{
	$model->home_text = $this->renderPartial('_form_editor_home_text', null, true);
	$model->about = $this->renderPartial('_form_editor_about', null, true);
	$model->contacts = $this->renderPartial('_form_editor_contacts', null, true);
	$model->terms = $this->renderPartial('_form_editor_terms', null, true);
}
?>
<div class="form" style="border: none">
	
	<div class="row description">
		<?php echo CHtml::label('',''); ?>
		<div style="float: left; padding: 5px 0 0 153px">
			<p>Here you can edit the static pages of your new site.</p>

			<p>The “home page”, “about page”, “contact us” and lastly the “terms and conditions”.</p>

			<p>They use an editor known as a WYSIWYG, which stands for “what you see is what you get”, which is not always true, but they do a good job of enabling an end user edit their own pages using your input to generate “HTML” code.</p>

			<p>Here is a manual that goes into some detail <a href="http://docs.cksource.com/CKEditor_3.x/Users_Guide/Quick_Reference" target="_blank">http://docs.cksource.com/CKEditor_3.x/Users_Guide/Quick_Reference</a></p>

			<p>And here is a youtube video that covers the basics <a href="http://youtu.be/m05WJpBcqz4" target="_blank">http://youtu.be/m05WJpBcqz4</a></p>

			<p>You have been provided with some basic layouts and suggestions, if you need help at all in editing these pages, please let us know.</p>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="row">
		<table style="width: auto">
			<tr>
				<td style="vertical-align: top"><?php echo $form->labelEx($model,'home_text'); ?></td>
				<td style="width: 100%">
					<?php $this->widget('application.extensions.eckeditor.ECKEditor', array(
						'model'=>$model,
						'attribute'=>'home_text',
						'config'=>array(
							'height'=>400
						)
					)); ?>
					<?php //echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50)); ?>
					<?php echo $form->error($model,'home_text'); ?>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="row">
		<table style="width: auto">
			<tr>
				<td style="vertical-align: top"><?php echo $form->labelEx($model,'about'); ?></td>
				<td style="width: 100%">
					<?php $this->widget('application.extensions.eckeditor.ECKEditor', array(
						'model'=>$model,
						'attribute'=>'about',
						'config'=>array(
							'height'=>400
						)
					)); ?>
					<?php //echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50)); ?>
					<?php echo $form->error($model,'about'); ?>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="row">
		<table style="width: auto">
			<tr>
				<td style="vertical-align: top"><?php echo $form->labelEx($model,'contacts'); ?></td>
				<td style="width: 100%">
					<?php $this->widget('application.extensions.eckeditor.ECKEditor', array(
						'model'=>$model,
						'attribute'=>'contacts',
						'config'=>array(
							'height'=>400
						)
					)); ?>
					<?php //echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50)); ?>
					<?php echo $form->error($model,'contacts'); ?>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="row">
		<table style="width: auto">
			<tr>
				<td style="vertical-align: top"><?php echo $form->labelEx($model,'terms'); ?></td>
				<td style="width: 100%">
					<?php $this->widget('application.extensions.eckeditor.ECKEditor', array(
						'model'=>$model,
						'attribute'=>'terms',
						'config'=>array(
							'height'=>400
						)
					)); ?>
					<?php //echo $form->textArea($model,'about',array('rows'=>6, 'cols'=>50)); ?>
					<?php echo $form->error($model,'terms'); ?>
				</td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>

</div><!-- form -->