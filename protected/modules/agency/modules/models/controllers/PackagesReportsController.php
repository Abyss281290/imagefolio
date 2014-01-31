<?php

class PackagesReportsController extends CAdminController
{
	public function accessRules()
	{
		return array(
			AgencyHelper::getAgencyPaidAccessRule(),
			array('allow',
				'roles'=>array('admin'),
			),
			array('deny',
				'expression'=>'AgencyModule::isAgencyHasPlanOption("packages") == false',
				'roles'=>array('agency','booker'),
			),
			array('allow',
				'actions'=>array('index','simple'),
				'roles'=>array('agency','booker'),
			),
			array('allow',
				'actions'=>array('delete'),
				'roles'=>array('agency','booker'),
				'expression'=>'($report = ModelsPackagesReports::model()->findByPk('.intval($_REQUEST['id']).')) && $report->sender_role == $user->role && $report->sender_user_id == $user->id'
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
	/*public function actionCreate()
	{
		$model=new ModelsPackagesReports;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ModelsPackagesReports']))
		{
			$model->attributes=$_POST['ModelsPackagesReports'];
			if($model->save())
				$this->redirect(array('index'));
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

		if(isset($_POST['ModelsPackagesReports']))
		{
			$model->attributes=$_POST['ModelsPackagesReports'];
			if($model->save())
				$this->redirect(array('index'));
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new ModelsPackagesReports('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ModelsPackagesReports']))
			$model->attributes=$_GET['ModelsPackagesReports'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	/**
	 * @desc render simple reports
	 */
	public function actionSimple($csv = 0)
	{
		$agency_id = AgencyModule::getCurrentAgencyId();
		$data = Yii::app()->db->createCommand()
			->selectDistinct('m.id AS model_id')
			->from(Models::tableName().' AS m')
			->leftJoin('{{agency_models_packages}} AS p', 'p.agency_id=:aid', array(':aid'=>$agency_id))
			->leftJoin('{{agency_models_packages_items}} AS pi', 'pi.package_id = p.id')
			->where('m.id = pi.model_id')
			->order('CONCAT(firstname, " ", lastname) ASC')
			->queryAll();
		
		$dateWhere = '';
		if(isset($_GET['date'])) {
			$toMysql = function($string) {
				$d = explode('/', $string);
				return implode('-', array($d[2],$d[0],$d[1]));
			};
			$from = $toMysql($_GET['date']['from']).' 00:00:00';
			$to = $toMysql($_GET['date']['to']).' 23:59:59';
			if($_GET['date']['from'] && $_GET['date']['to']) {
				$dateWhere .= "BETWEEN '{$from}' AND '{$to}'";
			} elseif($_GET['date']['from']) {
				$dateWhere .= ">= '{$from}'";
			} elseif($_GET['date']['to']) {
				$dateWhere .= "<= '{$to}'";
			}
			if($dateWhere)
				$dateWhere = ' AND (pr.send_time '.$dateWhere.')';
		}
		foreach($data as &$item) {
			$packages = Yii::app()->db->createCommand()
				->selectDistinct('pi.package_id')
				->from(array('{{agency_models_packages_reports}} pr', '{{agency_models_packages_items}} pi'))
				//->leftJoin('{{agency_models_packages_items}} pi', 'pi.model_id=:mid', array(':mid'=>$item['id']))
				->where('
					pr.package_id = pi.package_id
					AND pi.model_id=:mid'
					.$dateWhere,
					array(':mid'=>$item['model_id'])
				)
				->group('pr.package_id')
				->queryAll();
			$clients = Yii::app()->db->createCommand()
				->select('pr.id')
				->from(array('{{agency_models_packages_reports}} pr', '{{agency_models_packages_items}} pi'))
				//->leftJoin('{{agency_models_packages_items}} pi', 'pi.model_id=:mid', array(':mid'=>$item['id']))
				->where('
					pr.package_id = pi.package_id
					AND pi.model_id=:mid'
					.$dateWhere,
					array(':mid'=>$item['model_id'])
				)
				->group('pr.id')
				->queryAll();
			$model = Models::model()->findByPk($item['model_id']);
			$item['model_fullname'] = $model->fullname;
			$item['model_email'] = $model->email;
			$item['packages_num'] = count($packages);
			$item['clients_num'] = count($clients);
		}
		$totalPackages = (int)Yii::app()->db->createCommand()
			->select('COUNT(pr.package_id)')
			->from(array('{{agency_models_packages_reports}} pr'))
			->where('pr.agency_id=:aid'.$dateWhere, array(':aid'=>$agency_id))
			->group('pr.package_id')
			->queryScalar();
		if($csv) {
			Yii::import('ext.ECSVExport.*');
			Yii::import('ext.UrlTransliterate');
			$csv = new ECSVExport($data);
			$output = $csv->toCSV();
			$filename = UrlTransliterate::cleanString(
				'Package Simple Reports '.$_GET['date']['from'].'-'.$_GET['date']['to'],
				'_',
				true,
				false
			).'.csv';
			Yii::app()->getRequest()->sendFile($filename, $output, "text/csv", false);
			exit;
		} else {
			$dataProvider = new CArrayDataProvider($data, array(
				'sort'=>$s,
				'pagination'=>array(
					'pageSize'=>20
				)
			));
			$this->render('simple',array(
				'dataProvider'=>$dataProvider,
				'totalPackages'=>$totalPackages
			));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ModelsPackagesReports::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='models-packages-reports-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
