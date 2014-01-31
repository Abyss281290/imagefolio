<?php

class AdminController extends CAdminController
{
	public function accessRules()
	{
		return array(
			AgencyHelper::getAgencyPaidAccessRule(),
			/*array('deny',
				'actions'=>array('create'),
				'roles'=>array('agency','booker'),
				'expression'=>'AgencyModule::getAgency()->canAddModels() == false'
			),*/
			array('allow',
				'actions'=>array('index', 'create'),
				'roles'=>array('agency', 'booker'),
			),
			array('allow',
				'actions'=>array('update','delete','video','videoRemove','changeActivity','ajaxLoadCharacteristics','ajaxLoadSecondaryType','createMinibook'),
				'roles'=>array('agency', 'booker'),
				'expression'=>'in_array('.intval(isset($_REQUEST['model_id'])? $_REQUEST['model_id'] : $_REQUEST['id']).', array_merge(Models::getIdsByAgency($user->agency_id), array(0)))',
			),
			array('allow',
				'roles'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			)
		);
	}
	
	public function actionCreateMinibook($model_id, $type)
	{
		ModelsHelper::createMinibook($model_id, $type);
		die();
	}
	
	public function actionAjaxLoadCharacteristics($model_id, $type_id)
	{
		$model = Models::model()->findByPk($model_id);
		if(!$model)
			$model = Models::model();
		$this->renderPartial('_form_characteristics',array(
			'model'=>$model,
			'type'=> AgencyTypes::model()->findByPk($type_id),
			//'type2'=> AgencyTypes::model()->findByPk($type2_id),
		), false, true);
	}
	
	/*public function actionAjaxLoadSecondaryType($model_id, $type_id)
	{
		$model = Models::model()->findByPk($model_id);
		if(!$model)
			$model = Models::model();
		$this->renderPartial('_form_characteristics_secondary_type',array(
			'model'=>$model,
			'type_id'=>$type_id
		));
	}*/
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Models();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(AgencyModule::getAgency()->canAddModels() && isset($_POST['Models']))
		{
			$model->attributes=$_POST['Models'];
			if($model->save())
				$this->gotoGallery($model->id);
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
		
		ModelsHelper::setModelUpdateMenu($model);
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Models']))
		{
			$model->attributes=$_POST['Models'];
			if($model->save())
				$this->gotoGallery($model->id);
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
	
	public function actionChangeActivity($id)
	{
		$model = $this->loadModel((int)$id);
		if($model) {
			$model->active = intval(!$model->active);
			$model->update(array('active'));
		}
		echo Yii::app()->baseUrl . '/'. ($model->active
			? Yii::app()->params['imageStatusOn']
			: Yii::app()->params['imageStatusOff']);
		die();
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex($view = 'tile')
	{	
		$view = 'listing/'.($this->getViewFile('listing/'.$view)? $view : 'tile');
		$model = Models::model();
		$model->scenario = 'search';
		if(isset($_GET['Models']))
			$model->attributes=$_GET['Models'];
		
		ModelsPackagesHelper::addTrigger();
		
		$this->render('index',array(
			'model' => $model,
			'view'=>$view
		));
	}
	
	public function actionVideo($model_id)
	{
		$model=$this->loadModel($model_id);
		$model->scenario = 'video';
		ModelsHelper::setModelUpdateMenu($model);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Models']))
		{
			$model->attributes=$_POST['Models'];
			if($model->validate() && $model->uploadVideo('video')) {
				$this->redirect(array('admin/video/model_id/'.$model->id));
			}
		}

		$this->render('video',array(
			'model'=>$model,
		));
	}
	
	public function actionVideoRemove($id)
	{
		$model = $this->loadModel((int)$id);
		$model->removeVideo();
		$model->video = '';
		$model->update(array('video'));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = new Models();
		$item = $model->findByPk($id);
		if($item === null)
			throw new CHttpException(404,'Item not found');
		return $item;
	}
	
	public function gotoGallery($id)
	{
		$this->redirect(Yii::app()->getModule('gallery')->getAdminRoute('models', $id, '/agency/models/admin/index'));
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='content-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
