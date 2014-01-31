<?php
$bu = Yii::app()->request->baseUrl;
$tp = Yii::app()->theme->baseUrl;
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link href='http://fonts.googleapis.com/css?family=Cantarell' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Carme' rel='stylesheet' type='text/css'>
<link href="<?php echo $tp; ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $tp; ?>/css/grid.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="<?php echo $tp; ?>/images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo $tp; ?>/images/favicon.ico" type="image/x-icon" />
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-927552-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>




<script type="text/javascript">
	var templateUrl = '<?php echo $tp; ?>';
</script>
<script src="<?php echo $tp; ?>/js/scripts.js" type="text/javascript"></script>
<?php /* <script src="<?php echo $tp; ?>/js/forms.js" type="text/javascript"></script> */ ?>
<!--[if lt IE 8]>
  <div class='alc' style=' clear: both; text-align:center; position: relative; z-index:9999;'>
    <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
      <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
   </a>
 </div>
<![endif]-->
<!--[if lt IE 9]><script src="<?php echo $tp; ?>/js/html5.js" type="text/javascript"></script><![endif]-->
<!--[if IE]><link href="<?php echo $tp; ?>/css/ie_style.css" rel="stylesheet" type="text/css" /><![endif]-->
</head>
<body>
<div id="gspinner"></div>
<div id="glob">
	<h1><a href="#!/splash"><img src="<?php echo $tp; ?>/images/logo.png" alt="" /></a></h1>
	<nav>
		<ul>
			<li><a href="#!/about_us">About</a></li>
			<li><a href="#!/features">Features</a></li>
			<li><a href="#!/pricing">Pricing</a></li>
			<li><a href="#!/contacts">Contact</a></li>
   			<li><a href="#!/register">Register</a></li>
   			<li><a href="<?php echo $this->createUrl('/site/login'); ?>">Login</a></li>            
		</ul>
		<img src="<?php echo $tp; ?>/images/nav-hvr.png" class="nav-hvr" alt="" />
	</nav>
	<article id="content" class="container_16">
		<ul>
			<li id="home">
				<div class="alpha grid_10">
					<h2><span class="red">welcome</span> message</h2>
					<dl class="img-box">
						<dt><img src="<?php echo $tp; ?>/images/home-img-1.jpg" alt="" /></dt>
						<dd>
							<h3>ImageFolio Talent Agency Software</h3>
							<p>This system has been developed for over more than 10 years with some of the biggest names in the Industry including London's Premier Model Management. The systems management pages have been developed to be as intuitive and fast to use as possible, leveraging modern database and interface design and with no requirements for an agency beyond any computer with internet access. </p>
							<a href="#!/readmore" class="btn">Read More</a>
						</dd>
					</dl>
				</div>
				<div class="omega grid_5 prefix_1 border-left">
					<h2><span class="red">fresh</span> collections</h2>
					<div class="border-bottom">
						<ul class="list">
							<li><a href="#">avertaero kert asedolore sit</a></li>
							<li><a href="#">taserto yasers mertase</a></li>
							<li><a href="#">miaserder resertasade ertsde sertas buasri</a></li>
							<li><a href="#">taserto yasertase</a></li>
						</ul>
					</div>
					<ul class="list blo">
						<li><a href="#">dolore sit avertaero kertase</a></li>
						<li><a href="#">taserto yasers mertase</a></li>
						<li><a href="#">kersade delertsde miaserder rese rtajasres</a></li>
						<li><a href="#">iaserder rkersade delertsde hasrs</a></li>
						<li><a href="#">taserto yasertase</a></li>
					</ul>
				</div>
			</li>
			<li id="about_us">
				<div class="alpha grid_5">
					<h2><span class="red">ImageFolio</span> Talent Agency Software</h2>
<p>This system has been developed for over more than 10 years with some of the biggest names in the Industry including London's <a href="http://www.premiermodelmanagement.com" target="_blank" title="www.premiermodelmanagement.com">Premier Model Management</a>. The systems management pages have been developed to be as intuitive and fast to use as possible, leveraging modern database and interface design and with no requirements for an agency beyond any computer with internet access.
</p>
<p>Easily adapted with multiple portfolio layout and menu options, some variations can be seen on demos, <a href="http://imagefolio.net/ifl1/models/women3/carley" target="_blank" title="Demo with scrolling">here</a> and <a href="http://imagefolio.net/ifl2/models/women2/anna-holder" target="_blank" title="Demo with 9 images">here</a>.</p> 


<a href="#!/readmore" class="btn">read more</a>
				</div>
				<div class="omega grid_10 prefix_1 border-left">


                    <img src="<?php echo $tp; ?>/images/about.png" alt="">
				</div>
			</li>
			<li id="features">
				<?php echo $this->renderPartial('//site/pages/tour'); ?>
			</li>
			<li id="pricing">
				<div class="alpha grid_5">
					<h2><span class="red">Costs</span></h2>
<p>All ImageFolio hosting Options include the website, each Option allows varying numbers of Talents and images for each Talent to be hosted on ImageFolio, all Options have PDF MiniBooks and Video for each Talent.  Option 2, 3, 4 & 5 include the email broadcast package system, allowing you to send via the website customised collections of talents portfolios including large numbers of images both set for public and non-public view. Options 3, 4 & 5 additionally include the talent applicant submission system that is a great improvement over receiving and managing talent applications via email.
 Register and select the most suitable option for your agency, these can be upgraded at any time, and downgraded at the end of the current month.</p>
 
 <a href="#!/trial" class="btn2">no commitment trial</a>
				</div>
				<div class="omega grid_10 prefix_1 border-left">
						<div>
<img src="<?php echo $tp; ?>/images/pricing.png" width="534" height="183" alt="pricing"> 
<p><strong>Upgrades, Downgrades and Cancelling the Service.</strong> When you upgrade, you are credited, pro-rata for the amount of unused time for that month and asked to pay for the month ahead at the new rate less the credit. When you downgrade an account, you will be charged at the lower rate at the end of the current month. If you wish to cancel the service, all you need do is ignore and not pay the next invoice; your website admin page will become instantly inaccessible and the account automatically terminated after a period of 14 days with no amounts outstanding. </p>
</div>
					</div>
			</li>

			<li id="trial">
				<div class="alpha grid_5">
					<h2><span class="red">No Commitment 5 day trial</span></h2>
<p>For a Limited period we will be allowing you a 5 day grace period to test out our ImageFolio system, simply register and confirm your agency, choose a payment option, try out the system and if the Invoice is not paid at the end of the 5 days we will remove your account. All we ask in return, is that if you are not happy with some aspect of ImageFolio that you let us know.</p>
 

				</div>
				<div class="omega grid_10 prefix_1 border-left">
						<div>
<img src="<?php echo $tp; ?>/images/pricing.png" width="534" height="183" alt="pricing"> 
<p><strong>Upgrades, Downgrades and Cancelling the Service.</strong> When you upgrade, you are credited, pro-rata for the amount of unused time for that month and asked to pay for the month ahead at the new rate less the credit. When you downgrade an account, you will be charged at the lower rate at the end of the current month. If you wish to cancel the service, all you need do is ignore and not pay the next invoice; your website admin page will become instantly inaccessible and the account automatically terminated after a period of 14 days with no amounts outstanding. </p>
</div>
					</div>
			</li>


			<li id="news">
				<div class="alpha grid_11">
					<h2>latest news</h2>
					<div class="scroll">
						<div>
							<dl class="img-box blo">
								<dt><img src="<?php echo $tp; ?>/images/news-img-1.jpg" alt="" /></dt>
								<dd>
									<h3>latrsase miertas lertyasera mias<br>kertyasea lertyase vetas</h3>
									<p><strong>Ipsum dolosit ametct tueradi </strong>scieca<br>
		turpis rasamet arcuiet nsectetuer lerosertasra nefeugi dolorolor sit amet cotueseadreviverra neque feugi tolconsa placerater. Baseats miertasen biasrase kasryatser.
		Nasturpis ras sit amet arcuolor sit amet, consectetuer 
		adipiscing elonec viverra neque feugiat dolot consequap
		lacerat turpis ras sit amet arcu</p>
									<a href="#!/readmore" class="btn">read more</a>
								</dd>
							</dl>
							<dl class="img-box blo">
								<dt><img src="<?php echo $tp; ?>/images/news-img-1.jpg" alt="" /></dt>
								<dd>
									<h3>latrsase miertas lertyasera mias<br>kertyasea lertyase vetas</h3>
									<p><strong>Ipsum dolosit ametct tueradi </strong>scieca<br>
		turpis rasamet arcuiet nsectetuer lerosertasra nefeugi dolorolor sit amet cotueseadreviverra neque feugi tolconsa placerater. Baseats miertasen biasrase kasryatser.
		Nasturpis ras sit amet arcuolor sit amet, consectetuer 
		adipiscing elonec viverra neque feugiat dolot consequap
		lacerat turpis ras sit amet arcu</p>
									<a href="#!/readmore" class="btn">read more</a>
								</dd>
							</dl>
						</div>
					</div>
					<div class="scroll-btns">					
						<a href="#" data-type="scrollUp"></a>
						<a href="#" data-type="scrollDown"></a>
					</div>
				</div>
				<div class="omega grid_4 prefix_1 border-left">
					<h2><span class="red">news</span> archive</h2>
					<ul class="list">
						<li><a href="#">August 2012</a></li>
						<li><a href="#">July 2012</a></li>
						<li><a href="#">June 2012</a></li>
						<li><a href="#">May 2012</a></li>
						<li><a href="#">April 2012</a></li>
						<li><a href="#">March 2012</a></li>
						<li><a href="#">February 2012</a></li>
						<li><a href="#">January 2012</a></li>
						<li><a href="#">December 2011</a></li>
						<li><a href="#">November 2011</a></li>
						<li><a href="#">October 2011</a></li>
						<li><a href="#">September 2011</a></li>
						<li><a href="#">August 2011</a></li>
					</ul>
				</div>
			</li>
			<li id="contacts">
				<?php
				$controller = Yii::app()->createController('/site/');
				$controller[0]->actionContact();
				?>
			</li>
			<li id="register">
				<?php
				$controller = Yii::app()->createController('/agency/agencies/default/');
				$controller[0]->actionRegister();
				?>
			</li>
			<li id="register_confirm">
				<?php echo $this->renderPartial('//agency/agencies/default/register_confirm'); ?>
			</li>
			<li id="privacy">
				<?php echo $this->renderPartial('//site/pages/privacy'); ?>
			</li>
			<li id="terms">
				<?php echo $this->renderPartial('//site/pages/terms'); ?>
			</li>
			<li id="readmore">
				<h2><span class="red">Benefit</span>  from the expertise and experience of providers to leading talent agencies</h2>

<ul class="list">
<li>Extremely cost effective compared to our competitors Modasphere & cDs, for agencies of all sizes.</li>
<li>Have an instantly customizable site and email packages with 50 colour and style combinations.</li>
<li>Ability for you to host large numbers of various talent types, if a talent type is missing, let us know.</li>
<li>Simple uploading of images and videos maintaining their high quality.</li>
<li>Includes a simple client and contact management system.</li>
<li>Email broadcast packages of personalised collections of talent portfolios.</li>
<li>Ability to easily upgrade or downgrade with little or no notice.</li>
<li>Built on the most modern and robust technology available.</li>
<li>Cloud hosted to assure the fastest experience for both you and your clients.</li>
<li>Low costs of personalization beyond our standard templates.</li>
</ul>
			</li>
		</ul>
		<a href="#!/splash" class="close"><img src="<?php echo $tp; ?>/images/close.png" alt="" /></a>
	</article>
	<footer>
		<pre class="privacy">&copy; Net Tech Engineering Ltd  2013  <span class="bull">&bull;</span>  <a href="#!/privacy" class="nocolor upc und">Privacy policy</a> <span class="bull">&bull;</span>  <a href="#!/terms" class="nocolor upc und">Terms</a><!-- {%FOOTER_LINK} --></pre>
		<ul class="soc-links und nocolor">
				<li><a href="http://www.facebook.com/pages/ImageFolio/255748564481860"><img src="<?php echo $tp; ?>/images/facebook.png" alt="ImageFolio" target="blank" /></a></li>
		</ul>
	</footer>
</div>
<div id="bgStretch"><img src="<?php echo $tp; ?>/images/bg-1.jpg" alt="" /></div>
<!--coded by pleazkin-->
</body>
</html>