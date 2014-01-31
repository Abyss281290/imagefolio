<?php

class MenusController extends CAdminController
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCreate()
	{
		$model=new AgencyMenus;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgencyMenus']))
		{
			$model->attributes=$_POST['AgencyMenus'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgencyMenus']))
		{
			$model->attributes=$_POST['AgencyMenus'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}*/

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	/*public function actionDelete($id)
	{*
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
	}*/

	/**
	 * Lists all models.
	 */
	/*
	 public function actionIndex($agency_id)
	{
		$agency_id = (int)$agency_id;
		if(!Agencies::model()->exists('id=:id',array('id'=>$agency_id)))
			throw new CHttpException(404,'Agency not found');
		$model = AgencyMenus::model();
		//AgencyMenus::model()->findAll('active=1 AND agency_id=:aid', array(':aid'=>$agency_id));
		if(count($_POST))
		{
			if($menus = $model->findAll('agency_id=:aid', array('aid'=>$agency_id)))
				foreach($menus as $menu)
					$menu->delete();
			if(isset($_POST['menu'])) {
				$db =& Yii::app()->db;
				$insert = array();
				foreach($_POST['menu'] as $menu_index => $menu_type_id) {
					$menu_index = (int)$menu_index;
					$menu_type_id = (int)$menu_type_id;
					$insert[] = "(0, $agency_id, $menu_type_id)";
					if(isset($_POST['menu2'][$menu_index])) {
						foreach($_POST['menu2'][$menu_index] as $menu2_index => $menu2_type_id) {
							$menu2_type_id = (int)$menu2_type_id;
							$insert[] = "($menu_index, $agency_id, $menu2_type_id)";
						}
					}
				}
				if($insert) {
					$sql = "INSERT INTO {$model->tableName()}(parent_id, agency_id, type_id) VALUES ".implode(',',$insert);
					$db->createCommand($sql)->execute($parameters);
				}
			}
			//$this->redirect(array('index','agency_id'=>$agency_id));
		}
		$this->render('index',array(
			'model'=>$model,
		));
	}
	 */
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index'),
				'expression'=>'$user->agency_id=='.(int)$_REQUEST['agency_id'],
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
	
	public function actionIndex($agency_id)
	{
		$agency_id = (int)$agency_id;
		if(!Agencies::model()->exists('id=:id',array('id'=>$agency_id)))
			throw new CHttpException(404,'Agency not found');
		
		$model = AgencyMenus::model();
		$menus = $model->findAll('agency_id=:aid', array('aid'=>$agency_id));
		if(count($_POST))
		{
			if($menus)
				foreach($menus as $menu)
					$menu->delete();
			if(isset($_POST['menu'])) {
				foreach($_POST['menu'] as $menu_index => $menu_type_id) {
					$menu_index = (int)$menu_index;
					$menu_type_id = (int)$menu_type_id;
					$menu = new AgencyMenus();
					$menu->parent_id = 0;
					$menu->agency_id = $agency_id;
					$menu->type_id = $menu_type_id;
					$menu->save();
					if(isset($_POST['menu2'][$menu_index])) {
						$parent_id = $menu->id;
						foreach($_POST['menu2'][$menu_index] as $menu2_index => $menu2_type_id) {
							$menu2_type_id = (int)$menu2_type_id;
							$menu = new AgencyMenus();
							$menu->parent_id = $parent_id;
							$menu->agency_id = $agency_id;
							$menu->type_id = $menu2_type_id;
							$menu->save();
						}
					}
				}
			}
			$this->redirect(array('index','agency_id'=>$agency_id));
		}
		$this->render('index',array(
			'model'=>$model,
			'menus'=>$menus
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AgencyMenus::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='agency-menus-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
