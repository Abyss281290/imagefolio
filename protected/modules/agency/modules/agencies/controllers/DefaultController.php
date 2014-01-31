<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$items = Agencies::model()->findAll('active = 1');
		$this->render('index', array(
			'items' => $items
		));
	}
	
	public function actionSplash($id)
	{
		if(isset($_GET['skip'])) {
			$s = Yii::app()->session;
			$tmp = (array)$s->get('agencies_skip_splashes');
			$tmp[] = $id;
			$s->add('agencies_skip_splashes', $tmp);
			$this->redirect(array('default/view/', 'id'=>$id));
		}
		
		$model = $this->loadModel($id);
		
		if(!$model->splash->exists)
			$this->redirect('view', array('id'=>$model->id));
		
		$this->render('splash', array(
			'model' => $model
		));
	}
	
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		if($model->splash->exists && !in_array($id, (array)Yii::app()->session['agencies_skip_splashes'])) {
			$this->actionSplash($id);
			return;
		}
		$this->render('view', array(
			'model' => $model
		));
	}
	
	public function actionTerms($agency_id)
	{
		$model = $this->loadModel($agency_id);
		$this->render('terms',array('model'=>$model));
	}
	
	public function actionPrivacy($agency_id)
	{
		$model = $this->loadModel($agency_id);
		$this->render('//site/pages/privacy');
	}
	
	public function actionAbout($agency_id)
	{
		$model = $this->loadModel($agency_id);
		$this->render('about',array(
			'model'=>$model
		));
	}
	
	public function actionContact($agency_id)
	{
		$model = $this->loadModel($agency_id);
		$this->render('contact',array(
			'model'=>$model
		));
	}
	
	public function actionRegister()
	{
		$model=new Agencies('register');
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='form2')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
			exit;
		}
		
		if(isset($_POST['Agencies']))
		{
			$model->attributes=$_POST['Agencies'];
			
			// default content
			$model->home_text = $this->renderPartial('/admin/_form_editor_home_text', null, true);
			$model->about = $this->renderPartial('/admin/_form_editor_about', null, true);
			$model->contacts = $this->renderPartial('/admin/_form_editor_contacts', null, true);
			$model->terms = $this->renderPartial('/admin/_form_editor_terms', null, true);
			
			if($model->save()) {
				// send confirmation email
				$mailer = Yii::createComponent('ext.mailer.EMailer');
				$mailer->setFrom(Yii::app()->params['agencyRegistrationFromEmail'], Yii::app()->name.' Registration');
				$mailer->CharSet = 'utf-8';
				$mailer->IsHTML(true);
				$mailer->AddAddress($model->owner_email);
				$mailer->Subject = 'Agency registration confirmation for '.Yii::app()->name;
				$mailer->Body = $this->renderPartial('register_confirmation_letter', array('model'=>$model), true);
				$mailer->Send();
				
				//$this->redirect(array('registerDone'));
				echo '';
				exit;
			}
		}
		$this->renderPartial('register',array(
			'model'=>$model
		));
	}
	
	public function actionRegisterDone()
	{
		$model = new Agencies();
		$this->render('register_done',array(
			'model'=>$model
		));
	}
	
	public function actionConfirm($agency_id, $confirmation_key)
	{
		if($model = Agencies::model()->findByAttributes(array('id'=>$agency_id,'confirmation_key'=>$confirmation_key))) {
			if($model->confirmed) {
				throw new CHttpException(404,'Agency already confirmed');
			} else {
				$model->confirmed = 1;
				$model->update(array('confirmed'));
				
				// send admin registration notification
				$mailer = Yii::createComponent('ext.mailer.EMailer');
				$mailer->setFrom(Yii::app()->params['noreplyEmail'], Yii::app()->name.' Agency Registration');
				$mailer->CharSet = 'utf-8';
				$mailer->IsHTML(true);
				$mailer->AddAddress(Yii::app()->config->get('registrationNotificationEmail'));
				$mailer->Subject = 'New Agency Registration on '.Yii::app()->name;
				$mailer->Body = $this->renderPartial('register_admin_notification', array('model'=>$model), true);
				$mailer->Send();
				
				$this->redirect(Yii::app()->baseUrl.'#!/register_confirm');
				
				/*$this->render('register_confirm',array(
					'model'=>$model
				));*/
			}
		} else {
			throw new CHttpException(404,'Invalid agency id or confirmation key');
		}
	}
	
	public function loadModel($id)
	{
		$model=Agencies::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		AgencyFrontHelper::initAgency($model);
		
		return $model;
	}
}