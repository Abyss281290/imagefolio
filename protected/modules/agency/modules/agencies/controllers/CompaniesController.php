<?php

class CompaniesController extends CAdminController
{
	public function accessRules()
	{
		return array(
			AgencyHelper::getAgencyPaidAccessRule(),
			array('allow',
				'actions'=>array('index', 'create'),
				'roles'=>array('agency', 'booker'),
			),
			array('allow',
				'actions'=>array('update','delete'),
				'roles'=>array('agency'),
				'expression'=>'($company = AgencyCompanies::model()->findByPk($_REQUEST["id"])) && $company->agency_id == $user->agency_id',
			),
			array('allow',
				'actions'=>array('update','delete'),
				'roles'=>array('booker'),
				'expression'=>'($company = AgencyCompanies::model()->findByPk($_REQUEST["id"])) && $company->booker_id == $user->booker_id',
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AgencyCompanies;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgencyCompanies']))
		{
			$model->attributes=$_POST['AgencyCompanies'];
			if($model->save())
				$this->redirect(array('index'));
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

		if(isset($_POST['AgencyCompanies']))
		{
			$model->attributes=$_POST['AgencyCompanies'];
			if($model->save())
				$this->redirect(array('index'));
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new AgencyCompanies('search');
		if(isset($_GET['AgencyCompanies']))
			$model->attributes = $_GET['AgencyCompanies'];
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AgencyCompanies::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='agency-companies-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
