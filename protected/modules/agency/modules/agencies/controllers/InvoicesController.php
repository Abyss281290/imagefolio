<?php

class InvoicesController extends CAdminController
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
			array('allow',
				'actions'=>array('index'),
				'roles'=>array('agency'),
			),
			array('allow',
				'actions'=>array('view'),
				'expression'=>'($model = AgencyInvoices::model()->findByPk('.(int)$_REQUEST['id'].')) && $model->agency_id == $user->agency_id',
				'roles'=>array('agency'),
			),
			// allow action pay to all users (access to payment system)
			array('allow',
				'actions'=>array('pay'),
				'users'=>array('*'),
			),
			array('allow',
				'roles'=>array('admin'),
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
	/*public function actionCreate()
	{
		$model=new AgencyInvoices;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AgencyInvoices']))
		{
			$model->attributes=$_POST['AgencyInvoices'];
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

		if(isset($_POST['AgencyInvoices']))
		{
			$model->attributes=$_POST['AgencyInvoices'];
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
	/*public function actionDelete($id)
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
	}*/

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new AgencyInvoices('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AgencyInvoices']))
			$model->attributes=$_GET['AgencyInvoices'];
		
		$user = Yii::app()->user;
		
		if($user->isAgency()) {
			$invoicesTotalUnpaid = AgencyInvoices::getTotal(AgencyModule::getCurrentAgencyId(), true);
			$invoicesTotal = AgencyInvoices::getTotal(AgencyModule::getCurrentAgencyId(), false);
		} else {
			$invoicesTotalUnpaid = AgencyInvoices::getTotal(null, true);
			$invoicesTotal = AgencyInvoices::getTotal(null, false);
		}
		$invoicesTotalPaid = $invoicesTotal-$invoicesTotalUnpaid;
		
		if(Yii::app()->request->getParam('cancel')) {
			$user->addFlashWarning('payment-cancel', 'Your payment was canceled');
		}
		elseif(Yii::app()->request->getParam('success')) {
			$user->addFlashSuccess('payment-success', 'Payment was successful');
		}
		
		$this->render('index',array(
			'model'=>$model,
			'invoicesTotalUnpaid'=>$invoicesTotalUnpaid,
			'invoicesTotalPaid'=>$invoicesTotalPaid,
			'invoicesTotal'=>$invoicesTotal
		));
	}
	
	public function actionView($id)
	{
		$model = $this->loadModel($id, !Yii::app()->user->isAdmin());
		if(isset($_POST['AgencyInvoices'])) {
			$model->attributes=$_POST['AgencyInvoices'];
			if($model->save()) {
				$this->refresh();
			}
		}
		$this->render('view', array(
			'model'=>$model
		));
	}
	
	/**
	 * @desc Payment system handler
	 */
	public function actionPay()
	{
		//$s = print_r($_SERVER, 1);
		$paymentCfg = AgencyModule::getPaymentConfig();
		// payment system authentication
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
			header('WWW-Authenticate: Basic realm="Payment system auth"');
			header('HTTP/1.0 401 Unauthorized');
			//throw new CHttpException(403, 'Access denied');
			exit;
		} else {
			if($_SERVER['PHP_AUTH_USER'] != $paymentCfg['username'] || $_SERVER['PHP_AUTH_PW'] != $paymentCfg['password']) {
				throw new CHttpException(403, 'Username or password are incorrect');
				exit;
			}
		}
		
		$verbage = explode('/', $_REQUEST['Verbage']);
		$verbage = array_pop($verbage);
		
		$TEST = '';
		$TEST .= print_r($_REQUEST, true);
		$TEST .= "\n---------------\n";
		$TEST .= 'Verbage == Approved'.($verbage == 'Approved' || $verbage == 'Test Approved'? 'true' : 'false');
		$TEST .= "\n---------------\n";
		$TEST .= 'Unpaid invoices count for agency '.$_REQUEST['agency_id'].': '.AgencyInvoices::model()->notpaid()->countByAttributes(array('agency_id'=>$_REQUEST['agency_id']));
		file_put_contents(dirname(__FILE__).'/InvoicesController_actionPay.txt', $TEST);
		
		if($verbage == 'Approved' || $verbage == 'Test Approved')
		{
			$invoices = AgencyInvoices::model()->notpaid()->findAllByAttributes(array('agency_id'=>$_REQUEST['agency_id']));
			if($invoices) {
				foreach($invoices as $invoice) {
					$invoice->pay();
				}
				// update agency payment date
				// save agency payment day if it is first payment
				$agency = AgencyModule::getAgency($_REQUEST['agency_id']);
				$payment_date = $agency->payment_date && $agency->payment_date !== '0000-00-00'? $agency->payment_date : date('Y-m-d');
				$agency->payment_date = date('Y-m-d', strtotime(date('Y-m').'-'.date('d',strtotime($payment_date)).' +1 months'));
				$agency->update(array('payment_date'));

				PlansHelper::deleteOrRestoreModels($_REQUEST['agency_id']);

				//Yii::app()->user->addFlashSuccess('invoices-payment-ok', 'Payment successfully completed');
				echo count($invoices).' invoices was paid. Confirmation string: '.$paymentCfg['confirmation_string'];
				exit;
			} else {
				header('HTTP/1.0 400 Nothing to pay');
				echo 'Nothing to pay';
				exit;
				//throw new CHttpException(400,'Nothing to pay');
			}
			/*Yii::app()->db->createCommand()
				->update(
					AgencyInvoicesItems::tableName(),
					array(
						'paid'=>1,
						'paid_time'=>new CDbExpression('NOW()')
					),
					'invoice_id IN (SELECT id FROM '.AgencyInvoices::tableName().' WHERE agency_id = '.intval(Yii::app()->user->agency_id).')'
				);*/
			//$this->redirect(array('index'));
		}
		else
		{
			exit;
		}
	}
	
	public function actionMakePaid($invoice_id)
	{
		$invoice = AgencyInvoices::model()->findByPk($invoice_id);
		if($invoice) {
			$invoice->paid = (int)!$invoice->paid;
			if($invoice->paid) {
				$invoice->paid_time = new CDbExpression('NOW()');
				$invoice->payment_type = AgencyInvoices::PAYMENT_TYPE_CREDITCARD;
				PlansHelper::deleteOrRestoreModels($invoice->agency->id);
			} else {
				$invoice->paid_time = null;
				$invoice->payment_type = 0;
			}
			$invoice->update(array('paid','paid_time','payment_type'));
		}
		$this->redirect(array('view','id'=>$invoice_id));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id, $onlyActive = false)
	{
		$c = array();
		if($onlyActive) {
			$c['scopes'] = 'active';
		}
		$model=AgencyInvoices::model()->findByPk($id, $c);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='agency-invoices-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
