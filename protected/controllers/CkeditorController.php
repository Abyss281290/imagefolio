<?php
/**
 * Server-side part of visual editor
 * @see /extensions/imperavi
 */
class CkeditorController extends Controller
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
		$img = CUploadedFile::getInstanceByName('upload');
		$newImageName = md5($_SERVER['REMOTE_ADDR'].uniqid(time())).'.'.$img->getExtensionName();
		$imgUrl = '';
		$message = '';
		
		if (($_FILES['upload'] == "none") || (empty($_FILES['upload']['name'])) )
		{
			$message = "No file uploaded";
		}
		else if ($_FILES['upload']["size"] == 0)
		{
			$message = "The file is of zero length";
		}
		else if (($_FILES['upload']["type"] != "image/pjpeg") && ($_FILES['upload']["type"] != "image/jpeg") && ($_FILES['upload']["type"] != "image/png") && ($_FILES['upload']["type"] != "image/gif"))
		{
			$message = "The image must be in either JPG, PNG or GIF format. Please upload image with correct extension";
		}
		else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
		{
			$message = "Error";
		}
		else {
			if($img->saveAs($sysGalleryPath.DIRECTORY_SEPARATOR.$newImageName)) {
				$imgUrl = Yii::app()->baseUrl.'/'.$galleryPath.'/'.$newImageName;
			} else {
				$message = "Error";
			}
		}
		$funcNum = $_GET['CKEditorFuncNum'] ;
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$imgUrl', '$message');</script>";
		die();
	}
	
	public function actionSwfUpload()
	{
		$galleryPath = trim(Yii::app()->params->imperavi['imagesPath'], '/\\');
		$sysGalleryPath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$galleryPath;
		Yii::app()->image->createImagesDirectory($sysGalleryPath);
		$img = CUploadedFile::getInstanceByName('upload');
		$newImageName = md5($_SERVER['REMOTE_ADDR'].uniqid(time())).'.'.$img->getExtensionName();
		$imgUrl = '';
		$message = '';
		
		if (($_FILES['upload'] == "none") || (empty($_FILES['upload']['name'])) )
		{
			$message = "No file uploaded";
		}
		else if ($_FILES['upload']["size"] == 0)
		{
			$message = "The file is of zero length";
		}
		else if ($_FILES['upload']["type"] != "application/x-shockwave-flash")
		{
			$message = "The flash must be in SWF format. Please upload flash with correct extension";
		}
		else if (!is_uploaded_file($_FILES['upload']["tmp_name"]))
		{
			$message = "Error";
		}
		else {
			if($img->saveAs($sysGalleryPath.DIRECTORY_SEPARATOR.$newImageName)) {
				$imgUrl = Yii::app()->baseUrl.'/'.$galleryPath.'/'.$newImageName;
			} else {
				$message = "Error";
			}
		}
		$funcNum = $_GET['CKEditorFuncNum'] ;
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$imgUrl', '$message');</script>";
		die();
	}
}