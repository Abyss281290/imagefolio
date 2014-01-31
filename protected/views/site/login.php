<!doctype html>
<html lang="en-us">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
	<meta charset="utf-8">
	<title>Muse Admin Panel | Login</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- The Columnal Grid and mobile stylesheet -->
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/columnal/columnal.css" type="text/css" media="screen" />

	<!-- Fixes for IE -->
	<!--[if lt IE 9]>
            <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/columnal/ie.css" type="text/css" media="screen" />
            <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/ie8.css" type="text/css" media="screen" />
            <!--<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>-->
	<![endif]-->

	<!-- Now that all the grids are loaded, we can move on to the actual styles. --> 
        <link rel="stylesheet" href="assets/scripts/jqueryui/jqueryui.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/global.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/config.css" type="text/css" media="screen" />
        
</head>

<body id="login">
    <div class="container">
        <div class="row">
            
            
            <div class="col_6 pre_3 padding_top_60">
                <div class="widget clearfix">
                    <h2>Login</h2>
                    <div class="widget_inside">
                        <p class="margin_bottom_15">Please fill out the following form with your login credentials:</p>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));
echo $form->errorSummary($model, null, null, array('class' => 'notification undone'));
?>
                        <div class="form">
							<div class="clearfix">
                                <?php echo $form->label($model,'type'); ?>
								<div class="input">
									<?php echo $form->dropDownList($model,'type', array('agency'=>'Agency','booker'=>'Booker')); ?>
								</div>
                            </div>
                            <div class="clearfix">
                                <?php echo $form->label($model,'username'); ?>
								<div class="input">
									<?php echo $form->textField($model,'username'); ?>
								</div>
                            </div>
                            <div class="clearfix">
								<?php echo $form->label($model,'password'); ?>
								<div class="input">
									<?php echo $form->passwordField($model,'password'); ?>
								</div>
                            </div>
                            <div class="clearfix">
                                <div class="input no-label">
									<?php echo $form->label($model,'rememberMe'); ?>
									<?php echo $form->checkBox($model,'rememberMe'); ?>
                                </div>
                            </div>
                            <div class="clearfix grey-highlight">
                                <div class="input no-label ">
									<?php echo CHtml::submitButton('Login', array('class'=>'button blue')); ?>
									<?php echo CHtml::resetButton('Reset'); ?>
                                </div>
                            </div>
                        </div>
<?php $this->endWidget(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
