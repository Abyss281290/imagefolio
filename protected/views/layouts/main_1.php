<?php
$bu = Yii::app()->request->baseUrl;
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
<link href="<?php echo $bu; ?>/css/front/style.css" rel="stylesheet" type="text/css" />
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
	<div id="header" class="wrapper">
		<!-- Logo Start //-->
		<div id="logo" class="col-14 first">
			<a href="<?php echo Yii::app()->homeUrl; ?>"><img src="<?php echo $bu; ?>/images/logo.png" alt="logo" /></a>
		</div>
		<!-- Logo End //-->

		<!-- Navigation Start //-->
		  <div id="myslidemenu" class="jqueryslidemenu col-34 last">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/')),
					array('label'=>'Agencies', 'url'=>array('/agency/agencies')),
				),
			)); ?>
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
    <div id="footer" class="wrapper">
      <!-- About Us Start //-->
      <div class="footerbox col-24 first">
      <h4>About Us</h4>
      <img src="<?php echo $bu; ?>/images/about.jpg" alt="" class="alignleft imgbox" />
      <p id="abouttext">Praesent et ornare nibh. Aliquam convallis augue ac metus aliquet commodo. Sed ultrices diam libero. Mauris nec sem eget nisl sagittis...<a href="#" class="linkreadmore">Read more &raquo;</a></p>
      <ul class="social-links">
        <li><a href="http://twitter.com/"><img src="<?php echo $bu; ?>/images/twitter.png" alt="twitter" class="alignleft"/></a></li>
        <li><a href="http://id.linkedin.com/in/"><img src="<?php echo $bu; ?>/images/linkedin.png" alt="linkedin" class="alignleft"/></a></li>
        <li><a href="http://facebook.com/"><img src="<?php echo $bu; ?>/images/facebook.png" alt="facebook" class="alignleft"/></a></li>
        <li><a href="http://www.flickr.com/photos/"><img src="<?php echo $bu; ?>/images/flickr.png" alt="flickr" class="alignleft"/></a></li>
        <li><a href="http://www.youtube.com/user/"><img src="<?php echo $bu; ?>/images/youtube.png" alt="youtube" class="alignleft"/></a></li>
        <li><a href="#"><img src="<?php echo $bu; ?>/images/feed.png" alt="feed" class="alignleft"/></a></li>        
      </ul>
      <div class="clear"></div>
      <!-- Site Copyright Start //-->
      <div class="copyright">
        <p>&copy; 2010 - your company.com</p>
      </div>
      <!-- Site Copyright End //-->
      </div>
      <!-- About Us End //-->
      <!-- Office Address Start //-->    
      <div class="footerbox col-14">
      <h4>Office</h4>
      <p>Jln. Jalan terus no. 1 Pemalang 52354<br />Jawa Tengah, Indonesia<br />PO BOX 231252 JKT</p>
      </div>
      <!-- Office Address End //-->
      <!-- Contact Information Start //-->
      <div class="footerbox col-14 last">
      <h4>contact information</h4>
      <p>
      <strong>Phone</strong> : +62 23456789 <br/>
      <strong>Fax </strong>: +62 23456789 <br/>
      <strong>Email </strong>: <a href="mailto:Info@yourdomain.com">Info@yourdomain.com</a> <br/>
      <strong>Website </strong>: <a href="#">http://www.yourwebsite.com</a>
      </p>
      </div>
      <!-- Contact Information End //-->
    </div>       
    <!-- Footer End //-->
    <div class="clear"></div>
  </div>
  <!-- Footer Wrapper End //-->
</body>
</html>