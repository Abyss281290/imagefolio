<?php

class AdminController extends CAdminController
{
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('update'),
				'expression'=>'$user->agency_id=='.(int)$_REQUEST['id'],
				'roles'=>array('agency'),
			),
			array('allow',
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Agencies;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Agencies']))
		{
			$model->attributes=$_POST['Agencies'];
			if($model->save())
				$this->redirect(Yii::app()->user->isAgency()? array('update', 'id'=>$model->id) : array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Agencies']))
		{
			$model->attributes=$_POST['Agencies'];
			if($model->save())
				$this->redirect(Yii::app()->user->isAgency()? array('update', 'id'=>$model->id) : array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionImageRemove($id)
	{
		$module = Yii::app()->getModule('agency')->getModule('agencies');
		$model = $this->loadModel((int)$id);
		$model->removeMedia($module->logosPath, $model->image->source);
		$model->image = '';
		$model->update(array('image'));
	}
	
	public function actionBannerRemove($id)
	{
		$module = Yii::app()->getModule('agency')->getModule('agencies');
		$model = $this->loadModel((int)$id);
		$model->removeMedia($module->bannersPath, $model->banner->source);
		$model->banner = '';
		$model->update(array('banner'));
	}
	
	public function actionSplashRemove($id)
	{
		$module = Yii::app()->getModule('agency')->getModule('agencies');
		$model = $this->loadModel((int)$id);
		$model->removeMedia($module->splashesPath, $model->splash->source);
		$model->splash = '';
		$model->update(array('splash'));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = Agencies::model();
		if(isset($_GET['Agencies']))
			$model->attributes=$_GET['Agencies'];
		$this->render('index',array(
			'model'=>$model
		));
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

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='agencies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
