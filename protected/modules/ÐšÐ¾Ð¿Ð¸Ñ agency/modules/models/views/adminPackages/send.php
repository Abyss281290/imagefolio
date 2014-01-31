<?php
$this->breadcrumbs=array(
	'Agency'=>array('/agency/admin'),
	'Packages'=>array('index'),
	$package->title
);

$this->title = 'Send Package';

if($done && !count($_POST)) {
	$this->widget('ext.colorbox.JColorBox');
	Yii::app()->clientScript->registerScript('donemsg','$.colorbox({html: "<div style=\"padding:50px;font-weight:bold\">Thank you, email was sent to selected contacts</div>"})');
}
?>
<style type="text/css">
	.selected-list {
		display: block;
		margin-top: 5px;
		float: left;
	}
	.selected-list li {
		padding: 1px 3px 1px 1px;
		font-size: 11px;
		cursor: default;
		border-bottom: 1px solid #eee;
	}
	.selected-list li:hover {
		background: #eee;
		color: #000;
	}
	.selected-list a.btn {
		margin-right: 3px;
		display: inline-block;
		width: 16px;
		height: 16px;
		vertical-align: middle;
	}
	.selected-list a.btn.delete {
		background: url(<?php echo Yii::app()->baseUrl; ?>/images/notifications/cross.png) no-repeat left top;
	}
	.char-loader {
		display: none;
	}
</style>
<script type="text/javascript">
function selectContacts(dropdown_id)
{
	var to = $('#selected-list-'+dropdown_id);
	$('#'+dropdown_id).find('option:selected').each(function(k,v){
		var html = '<li>';
		html += '<input type="hidden" name="ModelsPackagesSendForm[to]['+dropdown_id+'][]" value="'+$(v).val()+'" />';
			html += '<a href="#" class="btn delete" onclick="return removeContact(this)"></a>';
			html += $(v).html();
		html += '</li>';
		to.append($(html));
	});
	return false;
}

function removeContact(objButton)
{
	$(objButton).closest('li').remove();
	return false;
}

function loadContacts(dropdown_id, char)
{
	var loader = $('#loader-char-'+dropdown_id);
	loader.show(0);
	jQuery.ajax({
		url: '<?php echo $this->createUrl('loadContactsList'); ?>',
		data: {package_id: <?php echo $package->id; ?>, type: dropdown_id, char: char},
		type: 'get',
		success: function(html){
			$('#list-container-'+dropdown_id).html(html);
			loader.hide(0);
		}
	});
}
</script>
<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation' => true,
		'clientOptions'=>array(
			'validateOnSubmit' => true,
			'validateOnChange' => true,
			'validateOnType' => false,
		),
		'htmlOptions' => array(
			//'enctype' => 'multipart/form-data'
		),
	)); ?>
	
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from',array('size'=>90,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'from'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'companies'); ?>
		<div class="left">
			<div class="textright margin_bottom_5">
				<?php echo CHtml::image(Yii::app()->baseUrl.'/'.Yii::app()->params['ajaxLoader'],'',array('id'=>'loader-char-companies','class'=>'char-loader')); ?>
				Select by Alphabetical
				<?php echo CHtml::dropDownList(
						'companies_char',
						key(CompaniesHelper::getDistinctNameFirstChars()),
						array(''=>'ALL')+CompaniesHelper::getDistinctNameFirstChars(),
						array('onchange'=>'loadContacts("companies",this.value)')
				); ?>
			</div>
			<div id="list-container-companies">
				<?php $this->renderPartial('send_list_companies',array('model'=>$model,'char'=>key(CompaniesHelper::getDistinctNameFirstChars()))); ?>
			</div>
			<div>
				<?php echo CHtml::link('Add','#',array('class'=>'button margin_top_5','onclick'=>'return selectContacts("companies")')); ?>
			</div>
			<div><ul id="selected-list-companies" class="selected-list"></ul></div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'contacts'); ?>
		<div class="left">
			<div class="textright margin_bottom_5">
				<?php echo CHtml::image(Yii::app()->baseUrl.'/'.Yii::app()->params['ajaxLoader'],'',array('id'=>'loader-char-contacts','class'=>'char-loader')); ?>
				Select by Alphabetical
				<?php echo CHtml::dropDownList(
						'contacts_char',
						'',
						array(''=>'ALL')+CompaniesHelper::getContactsDistinctNameFirstChars(),
						array('onchange'=>'loadContacts("contacts",this.value)')
				); ?>
			</div>
			<div id="list-container-contacts">
				<?php $this->renderPartial('send_list_contacts',array('model'=>$model,'char'=>'')); ?>
			</div>
			<div>
				<?php echo CHtml::link('Add','#',array('class'=>'button margin_top_5','onclick'=>'return selectContacts("contacts")')); ?>
				<div><ul id="selected-list-contacts" class="selected-list"></ul></div>
			</div>
			<ul id="selected-list-contacts"></ul>
		</div>
		<div class="clear"></div>	
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>90,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php $this->widget('ext.tinymce.ETinyMce', array(
			'model'=>$model,
			'attribute'=>'body',
			/*'options'=>array(
				'theme'=>'advanced',
				'theme_advanced_toolbar_location'=>'top',
				'theme_advanced_toolbar_align'=>'left'
			),*/
			'options'=>array(
				'theme_advanced_resizing'=>false,
				//'relative_urls'=>false,
				'convert_urls'=>false
			),
			'editorTemplate'=>'full',
			'useSwitch'=>false,
			'width'=>'550px',
			'height'=>'450px'
		)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo $form->labelEx($model,''); ?>
		<?php echo CHtml::submitButton('Send', array('class'=>'button blue')); ?>
		<?php echo CHtml::link('Cancel',$this->createUrl('index'),array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->