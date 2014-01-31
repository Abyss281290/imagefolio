<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CAdminController extends Controller
{
		/**
		 * @var is admin application
		 */
		public $admin = 1;

		/**
		 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
		 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
		 */

		public $layout='//layouts/admin';

		public $triggers = array();
	
	public function __construct($id, $module = null)
	{
		$user = Yii::app()->user;
		if($user->isAgencyMember())
		{
			$agency = AgencyModule::getAgency();
			$url = $agency->isPaid()
				? '/agency/models/admin/index'
				: '/agency/agencies/invoices/index';
		}
		else
		{
			// admin
			$url = '/agency/models/admin/index';
		}
		Yii::app()->homeUrl = $this->createUrl($url);
		
		parent::__construct($id, $module);
	}
	
	public function actions()
	{
		return array(
			'uploadify' => 'ext.uploadify.UploadFileAction',
		) + parent::actions();
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'roles'=>array('admin'),
			),
			array('allow',
				'users'=>array('*'),
				'actions'=>array('geo_getData')
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function beforeAction($action)
	{
		return parent::beforeAction($action);
	}
	
	public function beforeRender($view)
	{
		$user = Yii::app()->user;
		if($user->isAgencyMember()) {
			$agency = AgencyModule::getAgency();
			if(!$agency->plan_id)
			{
				$user->addFlashWarning('agency-no-plan', 'Your agency has no selected package. '.CHtml::link('Click here',$this->createUrl('/agency/agencies/plans/select')).' to select.');
			}
			elseif(!$agency->isPaid())
			{
				$user->addFlashError('agency-not-paid', 'Whilst there are unpaid invoices, some functions will be disabled, please '.CHtml::link('click here',$this->createUrl('/agency/agencies/invoices/index', array('paid'=>0))).' for the invoice list.');
			}
		}
		$this->widget('ext.KeepaliveWidget', array('interval'=>30*60)); // 30 min
		
		return parent::beforeRender($view);
	}
	
	/* Some standard actions
	*************************/
	
	/**
	 * Toggle record activity. Works if controller have loadModel() method
	 * @param type $id primary id of the record
	 */
	public function actionChangeActivity($id, $field = 'active')
	{
		$model = $this->loadModel((int)$id);
		if($model) {
			$model->$field = intval(!$model->$field);
			$model->update(array($field));
		}
		echo Yii::app()->baseUrl . '/'. ($model->$field
			? Yii::app()->params['imageStatusOn']
			: Yii::app()->params['imageStatusOff']);
		die();
	}
	
	/* Misc
	*************************/
	
	/**
	 * Add right side flying button
	 * @param: params like for the CHtml::link
	 */
	public function addTrigger()
	{
		// now it can be just one button
		$this->triggers = array(func_get_args());
	}
}