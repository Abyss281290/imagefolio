<?php
$app = Yii::app();
$user = $app->user;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-us">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
	<meta charset="utf-8" />
    <link rel="apple-touch-con" href="" />
	<title>Admin Panel</title>

        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">

	<!-- The Columnal Grid and mobile stylesheet -->
		<link rel="stylesheet" href="<?php echo $app->request->baseUrl; ?>/css/admin/columnal/columnal.css" type="text/css" media="screen" />

	<!-- Fixes for IE -->
        
	<!--[if lt IE 9]>
            <link rel="stylesheet" href="<?php echo $app->request->baseUrl; ?>/css/admin/columnal/ie.css" type="text/css" media="screen" />
            <link rel="stylesheet" href="<?php echo $app->request->baseUrl; ?>/css/admin/ie8.css" type="text/css" media="screen" />
            <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->        
        
	
	<!-- Now that all the grids are loaded, we can move on to the actual styles. --> 
        <link rel="stylesheet" href="<?php echo $app->request->baseUrl; ?>/css/admin/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo $app->request->baseUrl; ?>/css/admin/global.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $app->request->baseUrl; ?>/css/admin/config.css" type="text/css" media="screen" />

        <!-- Menu -->
        <link rel="stylesheet" href="<?php echo $app->request->baseUrl; ?>/js/superfish/superfish.css" type="text/css" media="screen" />
		<?php $app->clientScript->registerCoreScript('jquery'); ?>
        <script src="<?php echo $app->request->baseUrl; ?>/js/superfish/superfish.js"></script>

        
        <!-- Adds HTML5 placeholder element to those lesser browsers -->
        <script src="<?php echo $app->request->baseUrl; ?>/js/jquery.placeholder.1.2.min.shrink.js"></script>
        
        <!-- Custom Tooltips -->
        <script src="<?php echo $app->request->baseUrl; ?>/js/twipsy.js"></script>

</head>
<body>

<div id="wrap">
	<div id="main">
            <header class="container">
                <div class="row clearfix">
                    <div class="left">
                        <a href="<?php echo $app->homeUrl; ?>" id="logo">Premier</a>
                    </div>
                    
                    <div class="right">
                        <ul id="toolbar">
                            <li><span>Logged in as <b><?php echo CHtml::encode($user->name); ?></b> (<?php echo CHtml::encode(ucfirst($user->role)); ?>)</span></li>
                            <li><a id="messages" href="#">Messages</a></li>
                            <li><a id="settings" href="<?php echo $app->createUrl('/config/index'); ?>">Settings</a></li>
                        </ul>
						<?php
							if($user->isAdminAsAgency()):
								$mod = $app->getModule('agency')->getModule('agencies');
								$icon = $mod->assetPath.'/images/icon-log_out.png';
						?>
						
						<ul id="toolbar" class="back-to-admin">
                            <li>
								<?php echo CHtml::link(CHtml::image($icon).' Back to <b>Admin</b>', $this->createUrl('/agency/agencies/adminAuth/logout')); ?>
							</li>
                        </ul>
						<?php endif; ?>
                    </div>
                </div>
            </header>
            
            <nav class="container">
                <?php
				if($user->isAgencyMember() && (!AgencyModule::getAgency()->isPaid() || !AgencyModule::getAgency()->plan_id))
					$menu = 'agency_not_paid';
				else
					$menu = $user->role;
				$items = is_file($path = dirname(__FILE__).'/admin-menu/'.$menu.'.php')
					? require($path)
					: array();
				$this->widget('zii.widgets.CMenu',array(
                    'items'=>array_merge(array(
                        //array('label'=>'Dashboard', 'url'=>array('/admin/index')),
                    ),
					$items,
					array(
						/*array('label'=>'Model Agency', 'url'=>array('/agency/index'), 'items' => array(
							  array('label'=>'Models', 'url'=>array('/agency/models/admin/index')),
						)),*/
						//array('label'=>'News', 'url'=>array('/content/admin/index')),
                        //array('label'=>'Contact', 'url'=>array('/site/contact')),
                        array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>$user->isGuest),
                        array('label'=>'Logout ('.$user->name.')', 'url'=>array('/site/logout'), 'visible'=>!$user->isGuest)
                    )),
                    'htmlOptions' => array(
                        'class' => 'sf-menu mobile-hide row clearfix',
                    ),
                ));
				?>
            </nav>
		
		<?php if($this->triggers): ?>
		<div class="triggers">
			<?php foreach($this->triggers as $params): ?>
			<?php echo call_user_func_array(array('CHtml', 'link'), $params); ?>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>

<div id="titlediv">
    <div class="clearfix container" id="pattern">

        <div class="row">
            <div class="col_12">
                <?php if(isset($this->breadcrumbs)):?>
                    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links'=>$this->breadcrumbs,
                        'tagName'=>'ul',
                    )); ?><!-- breadcrumbs -->
                <?php endif?>
                <h1><?php echo $this->title ?></h1>
            </div>
        </div>

    </div>
</div>

<div class="container" id="actualbody">

<div class="row">
    <div class="widget clearfix">
		<?php if($this->menu): ?>
		<div id="content-menu" class="clearfix">
			<?php
			$this->widget('zii.widgets.CMenu',array(
				'items'=>$this->menu,
				'htmlOptions' => array(
					//'class' => 'sf-menu mobile-hide row clearfix',
					'class' => 'clearfix',
				),
				'encodeLabel'=>false
			));
			?>
		</div>
		<?php endif; ?>
		<?php
		foreach(Yii::app()->user->getFlashes() as $type => $messages) {
			foreach($messages as $key => $message) {
				echo CHtml::tag('div', array('class'=>'system-message '.$type.' '.$key), $message);
			}
		}
		?>
		<?php echo $content; ?>
    </div>


</div>

        </div><!--container -->

    </div>
</div>

<footer>
    <div class="container">
		<div class="row clearfix">
			<div class="col_12">
				<span class="left">&copy; <?php echo date('Y'); ?> <?php echo CHtml::encode(Yii::app()->params['developerTitle']); ?></span>
				<?php echo $footer; ?>

				<span class="right">
					<a href="<?php echo $this->createUrl('/site/page/view/terms'); ?>">Terms  of Service</a> &nbsp; •  &nbsp;<a href="<?php echo $this->createUrl('/site/page/view/privacy'); ?>">Privacy Statement</a>
				</span>

			</div>
		</div>
    </div>
</footer>

</body>
</html>