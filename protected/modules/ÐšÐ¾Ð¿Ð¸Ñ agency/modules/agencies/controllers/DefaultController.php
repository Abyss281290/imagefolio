<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$items = Agencies::model()->findAll('active = 1');
		$this->render('index', array(
			'items' => $items
		));
	}
	
	public function actionSplash($id)
	{
		if(isset($_GET['skip'])) {
			$s = Yii::app()->session;
			$tmp = (array)$s->get('agencies_skip_splashes');
			$tmp[] = $id;
			$s->add('agencies_skip_splashes', $tmp);
			$this->redirect(array('default/view/', 'id'=>$id));
		}
		
		$model = $this->loadModel($id);
		
		if(!$model->splash->exists)
			$this->redirect('view', array('id'=>$model->id));
		
		$this->render('splash', array(
			'model' => $model
		));
	}
	
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		if($model->splash->exists && !in_array($id, (array)Yii::app()->session['agencies_skip_splashes'])) {
			$this->actionSplash($id);
			return;
		}
		$this->render('view', array(
			'model' => $model
		));
	}
	
	public function actionAbout($agency_id)
	{
		$model = $this->loadModel($agency_id);
		$this->render('about');
	}
	
	public function actionContact($agency_id)
	{
		$model = $this->loadModel($agency_id);
		$this->render('contact');
	}
	
	public function loadModel($id)
	{
		$model=Agencies::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		
		AgencyFrontHelper::initAgency($model);
		
		return $model;
	}
}