<?php
/**
 * Server-side part of visual editor
 * @see /extensions/imperavi
 */
class ImperaviController extends Controller
{
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
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	
	public function actionImageUpload()
	{
		$galleryPath = trim(Yii::app()->params->imperavi['imagesPath'], '/\\');
		$sysGalleryPath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$galleryPath;
		Yii::app()->image->createImagesDirectory($sysGalleryPath);
		$img = CUploadedFile::getInstanceByName('file');
		$newImageName = md5($_SERVER['REMOTE_ADDR'].uniqid(time())).'.'.$img->getExtensionName();
		if($img->saveAs($sysGalleryPath.DIRECTORY_SEPARATOR.$newImageName)) {
			$imgUrl = Yii::app()->baseUrl.'/'.$galleryPath.'/'.$newImageName;
			echo stripslashes(CJSON::encode(array(
				'filelink'=>$imgUrl
			)));
		} else {
			echo 'Error';
		}
		die();
	}
}