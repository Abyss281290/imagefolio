<?php

class RequestsController extends Controller
{
	public function actionAjaxLoadCharacteristics($request_id, $type_id)
	{
		$model = ModelsRequests::model()->findByPk($request_id);
		if(!$model)
			$model = ModelsRequests::model();
		$this->renderPartial('create_characteristics',array(
			'model'=>$model,
			'type'=> AgencyTypes::model()->findByPk($type_id),
			//'type2'=> AgencyTypes::model()->findByPk($type2_id),
		), false, true);
	}
	
	/*public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ModelsRequests');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/
	
	public function actionCreate($agency_id)
	{
		$agency = Agencies::model()->findByPk($agency_id);
		if($agency===null)
			throw new CHttpException(404,'The requested page does not exist.');
		AgencyFrontHelper::initAgency($agency);
		$model = new ModelsRequests();
		$model->agency_id = $agency_id;
		
		if(isset($_POST['ModelsRequests']))
		{
			$model->attributes=$_POST['ModelsRequests'];
			if($model->save())
				$this->redirect(array('done', 'agency_id'=>$agency_id));
		}
		
		$this->render('create',array(
			'agency'=>$agency,
			'model'=>$model,
		));
	}
	
	public function actionDone($agency_id)
	{
		$agency = Agencies::model()->findByPk($agency_id);
		if($agency===null)
			throw new CHttpException(404,'The requested page does not exist.');
		//$model = $this->loadModel($request_id);
		AgencyFrontHelper::initAgency($agency);
		CHtml::refresh(10, $this->createUrl('create',array('agency_id'=>$agency_id)));
		$this->render('done',array(
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
		$model=ModelsRequests::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
