<?php
class UploadFileAction extends CAction
{
	public function run()
	{
		//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test.txt', $_FILES['Filedata']['tmp_name'].'///12313131');
		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$_REQUEST['folder'] = trim($_REQUEST['folder'], '/');
			$targetPath = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'tmp/';
			Yii::app()->image->createImagesDirectory($targetPath);
			//$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

			$fileParts  = pathinfo($_FILES['Filedata']['name']);
			$fileParts['extension'] = strtolower($fileParts['extension']);

			$prefix = microtime();
			$prefix = explode(' ', $prefix);
			$prefix[0] = substr($prefix[0], 2);
			$prefix = array_reverse($prefix);
			$prefix = implode('', $prefix);

			$newname = $prefix.'.'.$fileParts['extension'];

			$targetFile = str_replace('//','/',$targetPath).$newname;

			$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
			$fileTypes  = str_replace(';','|',$fileTypes);
			$typesArray = split('\|',$fileTypes);
			
			if (in_array($fileParts['extension'],$typesArray)) {
				// Uncomment the following line if you want to make the directory if it doesn't exist
				// mkdir(str_replace('//','/',$targetPath), 0755, true);

				if(@move_uploaded_file($tempFile,$targetFile)) {
					echo $newname;
				}
			} else {
				echo 'invalid extension';
			}
		}
		die();
	}
}
