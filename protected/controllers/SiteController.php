<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$model = ContentHelper::loadModel(1);
		$this->render('index',array(
			'model'=>$model
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='form1')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			exit;
		}
		
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				//$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				//mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				//Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				//$this->refresh();
				$mailer = Yii::createComponent('ext.mailer.EMailer');
				$mailer->From = $model->email;
				$mailer->FromName = $model->name;
				$mailer->CharSet = 'utf-8';
				$mailer->ContentType = 'text/html';
				$mailer->AddAddress(Yii::app()->config->get('adminEmail'));
				$mailer->Subject = 'New contact from '.Yii::app()->name;
				$mailer->Body = $this->renderPartial('contact_email',array('model'=>$model),true);
				$mailer->Send();
				
				echo '';
				exit;
				
				/*if(isset($_POST['ajax'])) {
					echo '1';
				} else {
					Yii::app()->user->addFlashSuccess('contact-success','Thank you for your message');
					$this->refresh();
					//$this->redirect(array('contact_done'));
				}*/
			}
		}
		$this->renderPartial('contact',array('model'=>$model));
	}
	
	public function actionContact_Done()
	{
		CHtml::refresh(5, $this->createUrl('contact'));
		$this->render('contact_done');
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				$user = Yii::app()->user;
				if($user->isAgency() || $user->isBooker())
				{
					PlansHelper::makeMonthlyCalculations();
					$agency = AgencyModule::getAgency();
					$redirect = array(
						$agency->isPaid()
							? '/agency/models/admin/index'
							: '/agency/agencies/invoices/index'
					);
				}
				else
				{
					$redirect = Yii::app()->user->getReturnUrl(array('/admin/index'));
				}
				$this->redirect($redirect);
			}
		}
		// display the login form
		$this->renderPartial('login', array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}