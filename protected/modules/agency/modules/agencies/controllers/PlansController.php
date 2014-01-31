<?php

class PlansController extends CAdminController
{
		public $layout = 'admin-invoices';
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('deny',
				'actions'=>array('select', 'confirmSelect', 'processSelection'),
				'roles'=>array('admin')
			),
			array('allow',
				'roles'=>array('admin'),
			),
			array('allow',
				'roles'=>array('agency'),
				'actions'=>array('select','confirmSelect'),
			),
			array('allow',
				'roles'=>array('agency'),
				'actions'=>array('processSelection'),
				'expression'=>'AgencyModule::getAgency()->isPaid() || !AgencyModule::getAgency()->plan'
			),
			array('deny',
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
		$model=new AgencyPlans;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgencyPlans']))
		{
			$model->attributes=$_POST['AgencyPlans'];
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

		if(isset($_POST['AgencyPlans']))
		{
			$model->attributes=$_POST['AgencyPlans'];
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new AgencyPlans('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AgencyPlans']))
			$model->attributes=$_GET['AgencyPlans'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionSelect($plan_id = 0)
	{
		$agency = Agencies::model()->findByPk(Yii::app()->user->agency_id);
		$dataProvider=new CActiveDataProvider('AgencyPlans', array(
			'sort'=>false,
			'pagination'=>false,
			'criteria'=>array(
				'order'=>'price ASC'
			)
		));
		$this->render('select',array(
			'dataProvider'=>$dataProvider,
			'agency'=>$agency
		));
	}
	
	public function actionConfirmSelect($plan_id)
	{
		$agency = Agencies::model()->findByPk(Yii::app()->user->agency_id);
		$currentPlan = $agency->plan_id
			? AgencyPlans::model()->findByPk($agency->plan_id)
			: null;
		$selectedPlan = $this->loadModel($plan_id);
		$this->render('select_confirm',array(
			'model'=>$model,
			'agency'=>$agency,
			'currentPlan'=>$currentPlan,
			'selectedPlan'=>$selectedPlan
		));
	}
	
	public function actionProcessSelection($plan_id)
	{
		$agency = Agencies::model()->findByPk(Yii::app()->user->agency_id);
		$currentPlan = $agency->plan_id
			? AgencyPlans::model()->findByPk($agency->plan_id)
			: null;
		$selectedPlan = $this->loadModel($plan_id);
		
		if($agency && AgencyPlans::model()->exists('id=:id',array(':id'=>$plan_id))) {
			$agency->plan_id = $plan_id;
			if($currentPlan) {
				$today = date('Y-m-d');
				$dayDiff = (strtotime($agency->payment_date." -1 months")-strtotime(date('Y-m-d')))/60/60/24;
				$dayDiff = $dayDiff < 0? -$dayDiff : $dayDiff;
				$dayDiff = max(1, $dayDiff);
				if($currentPlan->price > $selectedPlan->price) {
					// downgrade
					$invoice = InvoicesHelper::addInvoice(array(
						'title'=>$selectedPlan->title.' (Downgrade)',
						'description'=>'Package downgrade ('.$selectedPlan->title.') payment',
						'price'=>0
					));
					$invoice->paid = 1;
					$invoice->update(array('paid'));
				} else {
					// upgrade
					$price = $selectedPlan->price - $currentPlan->price - ($currentPlan->price / 31 * $dayDiff);
					$price = floor($price);
					$invoice = InvoicesHelper::addInvoice(array(
						'title'=>$selectedPlan->title.' (Upgrade)',
						'description'=>'Package upgrade ('.$selectedPlan->title.') payment',
						'price'=>$price
					));
					
					// unset payment date so it will be new at the next payment
					//$agency->payment_date = null;
				}
			} else {
				$invoice = PlansHelper::addInvoice($selectedPlan->id);
			}
			$agency->update(array('plan_id','payment_date'));
			
			/*Utility::sendMail(
				$agency->owner_email,
				$agency->full_name,
				'Payment package done',
				'...payment package done body...'
			);*/
			Yii::app()->user->addFlashSuccess('plan-selection-ok', 'You have upgraded to a new package');
			$this->redirect(array('invoices/index', 'paid'=>$invoice->paid));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AgencyPlans::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='agency-plans-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
