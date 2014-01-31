<?php

class AdminPackagesController extends CAdminController
{
	public function accessRules()
	{
		return array(
			array('deny',
				'actions'=>array('send'),
				'roles'=>array('admin'),
				'message'=>'Only agency or booker can send packages',
			),
			array('allow',
				'roles'=>array('admin'),
			),
			array('allow',
				'actions'=>array('index','make','viewModelImages','loadContactsList'),
				'roles'=>array('agency','booker'),
			),
			array('allow',
				'roles'=>array('agency'),
				'expression'=>'($package = ModelsPackages::model()->findByPk('.intval($_REQUEST['id']).')) && $package->agency_id == $user->agency_id',
			),
			array('allow',
				'roles'=>array('booker'),
				'expression'=>'($package = ModelsPackages::model()->findByPk('.intval($_REQUEST['id']).')) && $package->booker_id == $user->booker_id',
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
		$model=new ModelsPackages;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ModelsPackages']))
		{
			$model->attributes=$_POST['ModelsPackages'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}*/
	
	public function actionSend($id, $done=0)
	{
		$package = $this->loadModel($id);
		$model = new ModelsPackagesSendForm();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ModelsPackagesSendForm']))
		{
			$model->attributes=$_POST['ModelsPackagesSendForm'];
			if($model->validate()) {
				// send package
				$contacts = array();
				foreach($model->to as $contacts_type => $ids) {
					switch($contacts_type)
					{
						case 'companies':
							$items = AgencyCompanies::model()->findAllByPk($ids);
							foreach($items as $item)
								$contacts[$item->email] = array($item->email, $item->name);
							break;
						case 'contacts':
							$items = AgencyCompaniesContacts::model()->findAllByPk($ids);
							foreach($items as $item)
								$contacts[$item->email] = array($item->email, $item->name);
							break;
					}
				}
				$mailer = Yii::createComponent('ext.mailer.EMailer');
				foreach($contacts as $contact) {
					// we can obtain an empty email
					if(!$contact[0])
						continue;
					//$mailer->From = $model->from;
					//$mailer->FromName = $model->from;
					$mailer->setFrom($model->from);
					$mailer->CharSet = 'utf-8';
					$mailer->ContentType = 'text/html';
					$mailer->AddAddress($contact[0]);
					$mailer->Subject = $model->subject;
					$mailer->Body = strtr($model->body, array(
						'{client_name}' => $contact[1],
						'{package_url}' => ModelsPackagesHelper::getFrontViewLink($package)
					));
					$mailer->Send();
					$mailer->ClearAllRecipients();
				}
				$this->redirect(array('send','id'=>$package->id,'done'=>1));
			}
		}
		
		$this->render('send',array(
			'package'=>$package,
			'model'=>$model,
			'done'=>$done
		));
	}
	
	public function actionLoadContactsList($package_id, $type, $char)
	{
		$model = $this->loadModel($package_id);
		$this->renderPartial('send_list_'.$type, array(
			'model'=>$model,
			'char'=>$char
		));
		exit;
	}
	
	public function actionMake()
	{
		if(count($_POST)) {
			Yii::app()->getModule('gallery');
			// item_type => post_name
			$names = array('model'=>'models','image'=>'images');
			$response = array(
				'errors'=>array(),
				'redirect'=>'',
			);
			if(!$_POST[$names['model']] && !$_POST[$names['image']])
			{
				$response['errors'][] = 'Select model or images to make a package';
			}
			else
			{
				$items = array();
				$new_items = array();
				if($_POST['extend'] > 0)
				{
					// extend package
					// 1 item ???
					$package = ModelsPackages::model()->findByPk($_POST['extend']);
					if($package && $package->save()) {
						$items = array();
						if($package->items)
							foreach($package->items as $item)
								$items[] = $item->item_id;
						$new_items = $this->_makePackageProcessItems();
					} else {
						$response['errors'][] = 'Package do not exist';
					}
				}
				else
				{
					// make new package
					$user = Yii::app()->user;
					$package = new ModelsPackages();
					$package->setAttributes(array(
						'title'=>$_POST['new_title']
					));
					if($user->isAgency())
						$package->agency_id = $user->agency_id;
					if($user->isBooker())
						$package->booker_id = $user->booker_id;
					if($package->save()) {
						$new_items = $this->_makePackageProcessItems();
					}
					$response['errors'] = array_values($package->getErrors());
				}
				if($new_items) {
					foreach($new_items as $model_id=>$new_items2) {
						//$new_items2 = array_unique($new_items2);
						foreach($new_items2 as $id) {
							if(in_array($id, $items))
								continue;
							$items[] = $id;
							$item = new ModelsPackagesItems();
							$item->package_id = $package->id;
							$item->model_id = $model_id;
							$item->item_type = 'image';
							$item->item_id = $id;
							$item->save();
						}
					}
				}
			}
			if(!count($response['errors']))
				$response['redirect'] = $this->createUrl('update',array('id'=>$package->id));
			
			echo CJSON::encode($response);
			exit;
		}
		$this->renderPartial('overlay-form');
	}
	
	private function _makePackageProcessItems()
	{
		$new_items = array();
		foreach(array('models','images') as $item_type) {
			if(is_array($_POST[$item_type]) && count($_POST[$item_type])) {
				foreach($_POST[$item_type] as $item_id) {
					if($item_type == 'models') {
						$model_id = $item_id;
						if($model = Models::model()->findByPk($model_id))
							if($model->gallery && $model->gallery->images)
								foreach($model->gallery->images as $img)
									if($img->public || $img->main)
										$new_items[$model_id][] = $img->id;
					} elseif($item_type == 'images') {
						$image = GalleryImage::model()->findByPk($item_id);
						if(!$image)
							continue;
						$model_id = $image->gallery->item_id;
						$new_items[$model_id][] = $image->id;
					}
				}
			}
		}
		return $new_items;
	}
	
	public function actionDeleteItem($item_id)
	{
		ModelsPackagesItems::model()->deleteByPk($item_id);
	}
	
	public function actionDeleteModel($package_id, $model_id)
	{
		$model = ModelsPackagesItems::model()->deleteAllByAttributes(array(
			'package_id'=>$package_id,
			'model_id'=>$model_id
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

		if(isset($_POST['ModelsPackages']))
		{
			$model->attributes=$_POST['ModelsPackages'];
			if($model->save())
				$this->redirect(array('index'));
		}
		
		$this->render('update',array(
			'model'=>$model
		));
	}
	
	public function actionViewModelImages($package_id,$model_id)
	{
		$model=$this->loadModel($package_id);
		$this->renderPartial('_items_images',array('model'=>$model,'model_id'=>$model_id));
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new ModelsPackages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ModelsPackages']))
			$model->attributes=$_GET['ModelsPackages'];

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
		$model=ModelsPackages::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='models-packages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
