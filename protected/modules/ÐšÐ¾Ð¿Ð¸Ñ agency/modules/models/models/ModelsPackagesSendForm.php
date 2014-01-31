<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ModelsPackagesSendForm extends CFormModel
{
	public $from;
	public $to;
	public $subject;
	public $body;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('from, to, subject, body', 'required'),
			// email has to be a valid email address
			//array('email', 'email'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * If not declared here, an attribute would have a label that is
	 * Declares customized attribute labels.
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'companies'=>'Clients'
		);
	}
	
	public function afterConstruct()
	{
		$package = ModelsPackages::model()->findByPk((int)$_REQUEST['id']);
		if(!$package->agency)
			throw new CHttpException('404','Package agency not found');
		$user = Yii::app()->user;
		$controller = Yii::app()->controller;
		
		$this->from = $user->email;
		$this->subject = $package->title.' - '.$package->agency->full_name;
		$this->body = $controller->renderPartial('send_message_body',array(
			'package'=>$package
		),true);
		parent::afterConstruct();
	}
}