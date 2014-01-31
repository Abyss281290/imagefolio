<?php
$agency = Yii::app()->params['agency'];

$bu = Yii::app()->request->baseUrl;
$tp = Yii::app()->theme->baseUrl;
$mc = Yii::app()->themeManager->getTheme($agency->color_menu)->baseUrl;

if(!$this->logo)
	$this->logo = array();
if(!isset($this->logo['image']))
	$this->logo['image'] = $bu.'/images/logo.png';
if(!isset($this->logo['url']))
	$this->logo['url'] = Yii::app()->homeUrl;

if(is_array($this->pageTitle))
	$this->pageTitle = implode(' - ',$this->pageTitle);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="title" content="" />
  <meta name="description" content="" />
  <title><?php echo CHtml::encode($this->pageTitle); ?></title>

<!-- Stylesheets Start //-->
<link href="<?php echo $tp; ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $mc; ?>/css/jqueryslidemenu.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $bu; ?>/css/front/global.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $bu; ?>/css/front/agency.css" rel="stylesheet" type="text/css" />
<!-- Stylesheets End //-->

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<!-- Javascript Start //-->
<script type="text/javascript" src="<?php echo $bu; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $bu; ?>/js/jqueryslidemenu.js"></script>
<script type="text/javascript" src="<?php echo $bu; ?>/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo $bu; ?>/js/coin-slider.min.js"></script>
<script type="text/javascript" src="<?php echo $bu; ?>/js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo $bu; ?>/js/fonts/ColaborateLight.js"></script>
<script type="text/javascript" src="<?php echo $bu; ?>/js/functions.js"></script>
<script type="text/javascript" src="<?php echo $bu; ?>/js/sexy-combo/jquery.sexy-combo.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $bu; ?>/js/sexy-combo/css/sexy-combo.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $bu; ?>/js/sexy-combo/css/sexy/sexy.css" />
<script type="text/javascript">
var sexyCombo = function(){ if($.sexyCombo) $("select:visible").sexyCombo() }
$(document).ready(function(){
	sexyCombo();
	$(document).ajaxComplete(sexyCombo);
	//$(document).bind('DOMSubtreeModified', function(){alert(1)})
});
//$(document).ajaxComplete(function(){alert(1)});
var baseUrl = '<?php echo Yii::app()->baseUrl; ?>';

<?php if($agency->google_analytics_account): ?>
// google
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo CHtml::encode($agency->google_analytics_account); ?>']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
<?php endif; ?>
</script>
<!-- Javascript End //-->
<script type="text/javascript">
  
	$(document).ready(function() {
		$('#coin-slider').coinslider({ width: 940, height: 400,navigation: true, delay: 3000})
	});
</script>
	<!-- PNG transparency fix for IE 6 -->
	<!--[if IE 6]>
  	<script src="js/pngfix.js"></script>
  	<script>DD_belatedPNG.fix('#logo img,img');</script>
	<![endif]-->

</head>
<body>
    <div id="headerwrapper">
    <!-- Header Start //--> 
	<div id="header" class="wrapper2">
		<!-- Logo Start //-->
		<div id="logo" class="col-14 first">
			<?php echo CHtml::link(CHtml::image($this->logo['image']), $this->logo['url']); ?>
		</div>
		<!-- Logo End //-->

		<!-- Navigation Start //-->
		  <div id="myslidemenu" class="jqueryslidemenu col-34 last">
			<?php
			$this->widget(
				'zii.widgets.CMenu',
				$this->menu
					? $this->menu
					: array(
						'items'=>array(
							array('label'=>'Home', 'url'=>array('/')),
							array('label'=>'About', 'url'=>array('/site/page/view/about')),
							array('label'=>'Tour', 'url'=>array('/site/page/view/tour')),
							array('label'=>'Clients', 'url'=>array('/agency/agencies')),
							array('label'=>'Contact', 'url'=>array('/site/contact')),
							array('label'=>'Register', 'url'=>array('/agency/agencies/default/register')),
							array('label'=>'Login', 'url'=>array('/site/login')),
						),
					)
			);
			?>
			<div class="clear"></div>
		</div>
		<!-- Navigation End //-->
	</div>
	<div class="clear"></div>
  <!-- Header End //-->
  </div>
  <!-- Header Wrapper End //-->
  
  <!-- Wrapper Start //-->  
	<div class="wrapper">
		<?php if(isset($this->breadcrumbs)): ?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'tagName'=>'ul',
				'homeLink'=>false
			)); ?>
		<?php endif; ?>
		<?php if(strval($this->title) !== ''): ?>
		<h2><?php echo $this->title; ?></h2>
		<?php endif; ?>
		<?php echo $content; ?>
		<div class="clear"></div>
	</div>
    <!-- Wrapper End //-->
    
    <!-- Footer Wrapper Start //-->
    <div id="footerwrapper">
    <!-- Footer Start //-->
    <div id="footer" class="wrapper2">
      <!-- About Us Start //-->
    <div class="footerbox col-24 first">
      <p>Copyright &copy; <?php echo date('Y'); ?>  <?php echo CHtml::encode($agency->full_name); ?>
	  <br /><?php echo CHtml::link('Talent Agency Software ImageFolio', 'http://imagefolio.net'); ?></p>

	
	   
	  
      <div class="clear"></div>
      
	  <!-- Site Copyright Start //-->
	  <!--
      <div class="copyright">
        <p>&copy; ImageFolio 2012</p>
      </div>
      -->
	  <!-- Site Copyright End //-->
    </div>
      <!-- About Us End //-->
      
	  <!-- Office Address Start //-->    
      <!--<div class="footerbox col-14">
      <h4>Terms</h4>
      <p><a href="http://beta.imagefolio.net/site/page/view/terms">Terms</a></p>

      </div> -->
      <!-- Office Address End //-->
	  
	  <!-- Office Address Start //-->  
		  
      <div class="footerbox col-14">
    
      <p>&nbsp;</p>
      </div>
	
      <!-- Office Address End //-->


      <!-- Contact Information Start //-->
    <div class="footerbox col-14 last">
      <p>&nbsp; <a href="<?php echo $this->createUrl('/agency/agencies/default/terms',array('agency_id'=>$agency->id)); ?>">Terms  of Service</a> &nbsp; •  &nbsp;<a href="<?php echo $this->createUrl('/agency/agencies/default/privacy',array('agency_id'=>$agency->id)); ?>">Privacy Statement</a></p>
      </div> 
      <!-- Contact Information End //-->
    </div>       
    <!-- Footer End //-->
    <div class="clear"></div>
  </div>
  <!-- Footer Wrapper End //-->
</body>
</html>