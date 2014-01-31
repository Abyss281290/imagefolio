<?php
$this->title = 'ImageFolio Talent Agency Software';//$model->title;

$homeImagesPath = Yii::app()->baseUrl.'/images/home';
?>
<style type="text/css">
.normalhome {
   font-size: 14px;
   font-family: Calibri;
   vertical-align: top;
   padding: 0 0 10px 40px; 
}


.normalhome p {
	   margin: 0 0 15px 0;
}

.normalhome ul {
	   margin: 0 0 0 0;
	   padding:0;
}
.normalhome ul li {
	     list-style: none;
	     background: url(<?php echo $homeImagesPath; ?>/arrow.png) no-repeat 0 0px;;
	     font-weight: 100;
color:#777;
	    font-size: 16px;
	   font-family: Calibri;
	   padding: 0 0 0 40px;
	   margin:  10px 0 15px 0;
	   line-height: 20px;
}

p.black {
		    font-size: 16px;
	   font-family: Calibri;
	 
	   margin:  80px 0 15px 40px;
	   line-height: 20px;
	   color:#000;
}
</style>
<div class="agency-terms wysiwyg-content">
	<?php //echo $model->content; ?>
	<h2 class="current" style="color: rgb(247, 150, 70);">Enabling talent agencies of all sizes to present....</h2>
	<div class="container">
	<div id="content">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="<?php echo $homeImagesPath; ?>/home-1.jpg" alt="" width="436" height="294" /></td>
    <td class="normalhome" style="padding-left: 50px">
<p>	This system has been developed for over more than 10 years with some of 
the biggest names in the Industry</p> 

<p>It exists to allow the agency to sell the services of their registered talent to their Clients. 
This is facilitated by allowing the Client to easily identify talent that best meet their 
needs and by allowing the agency to send showcase portfolios of their talent to their Client.</p>  

<p>The systems management pages have been developed to be as intuitive and fast to use as 
possible, leveraging modern database and interface design.</p>

<p>ImageFolio.net has no requirements for an agency beyond any computer with internet access. </p>


	</td>
  </tr>
  <tr>
    <td class="normalhome">
	<h1>Features:</h1>
	<ul>
      <li>Auto-cropping of images on upload, a wide variety of video formats         accepted, automatic PDF &quot;minibooks&quot;, broadcast emailed packages on 
        multiple talents to multiple clients.</li>
      <li>Multiple Layouts available, with different colour schemes, customisable 
        static  pages, with a large number of standard talent types and 
        divisions catered for. </li>
      <li>        Models characteristics available in Imperial (UK &amp; US) &amp; Metric (EU) 
        and combinations, ability to host creatives including photographers, 
        makeup artists, stylists to name but a few.</li>
      <li>Form based talent submission system, allowing easy assessment and 
        management of talent applications.
      </li>
    </ul>
      <p class="black">
	  Take a more detailed <?php echo CHtml::link('look here',$this->createUrl('/site/page/view/tour')); ?>  and check out our low cost <?php echo CHtml::link('pricing schedule',$this->createUrl('/site/page/view/about')); ?>, feel free to <?php echo CHtml::link('contact us',$this->createUrl('/site/contact')); ?> with any question. 
Customized versions available on <?php echo CHtml::link('request',$this->createUrl('/site/contact')); ?>. </p></td>
    <td><img src="<?php echo $homeImagesPath; ?>/home-2.jpg" alt="" width="540" height="629" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

	
	
	
	</div><!-- content -->
</div>
</div>