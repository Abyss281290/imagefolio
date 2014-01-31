<?php

class AdminAuthController extends CAdminController
{
	public function accessRules()
	{
		return array(
			array('allow',
				'roles'=>array('admin'),
			),
			array('allow',
				'roles'=>array('agency'),
				'actions'=>array('logout'),
				'expression'=>'$user->isAdminAsAgency()'
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionLogin($agency_id)
	{
		$model = $this->loadModel($agency_id);
		$user = Yii::app()->user;
		$admin_id = $user->id;
		$user->logout(false);
		$identity = new UserIdentity('agency', $model->owner_login, null);
		$identity->setAgencyStates($model);
		$identity->setState('admin_id', $admin_id);
		$user->login($identity);
		
		$this->redirect(array('/admin/index'));
	}
	
	public function actionLogout()
	{
		$user = Yii::app()->user;
		$model = User::model()->findByPk($user->admin_id);
		if(!$model)
			throw new CHttpException(404,'The requested page does not exist.');
		$user->logout(false);
		$identity = new UserIdentity('admin', $model->username, null);
		$identity->setAdminStates($model);
		$user->login($identity);
		
		$this->redirect(array('/admin/index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Agencies::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
