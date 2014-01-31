<?php

class CharacteristicsController extends CAdminController
{
	public function actionAjaxLoadElementData($characteristicId, $selectedType)
	{
		$model = AgencyCharacteristics::model()->findByPk($characteristicId);
		$this->renderPartial('_form_element_data', array(
			'selectedType'=>$selectedType,
			'model'=>$model
		), false, true);
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AgencyCharacteristics;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgencyCharacteristics']))
		{
			$model->attributes=$_POST['AgencyCharacteristics'];
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

		if(isset($_POST['AgencyCharacteristics']))
		{
			$model->attributes=$_POST['AgencyCharacteristics'];
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new AgencyCharacteristics('search');
		if(isset($_GET['AgencyCharacteristics']))
			$model->attributes=$_GET['AgencyCharacteristics'];
		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionOrder()
	{
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			foreach ($_POST['items'] as $i=>$id) {
				$project = AgencyCharacteristics::model()->findByPk($id);
				$project->order = $i+1;
				$project->save();
			}
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AgencyCharacteristics::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='agency-characteristics-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
