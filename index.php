<?php 
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

error_reporting(0);

if($_GET['debug']){
    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',0);
}
/*
if(in_array($_SERVER['REMOTE_ADDR'], array('94.179.234.65','95.67.121.182'))){
    defined('ANDREW_DEBUG') or define('ANDREW_DEBUG', true);
}
**/

require_once($yii);
Yii::createWebApplication($config)->run();

?>

