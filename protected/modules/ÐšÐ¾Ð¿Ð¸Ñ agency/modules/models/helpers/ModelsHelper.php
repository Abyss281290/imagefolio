<?php
class ModelsHelper
{
	public static function setModelUpdateMenu($model)
	{
		$controller = Yii::app()->controller;
		$menu = array(
			array(
				'label'=>'Update Model',
				'url'=>$controller->createUrl('/agency/models/admin/update',array('id'=>$model->id)),
				'active'=>$controller->action->id == 'update'
			),
			array(
				'label'=>CHtml::image(Yii::app()->baseUrl.'/images/gallery.png').' Gallery',
				'url'=>Yii::app()->getModule('gallery')->getAdminRoute("models", $model->id, "/agency/models/admin/index"),
				'active'=>$controller->module->id == 'gallery' && $_REQUEST['gallerycode'] == 0 
			),
			array(
				'label'=>CHtml::image(Yii::app()->baseUrl.'/images/gallery.png').' Polaroids',
				'url'=>Yii::app()->getModule('gallery')->getAdminRoute("models", $model->id, "/agency/models/admin/index",1),
				'active'=>$controller->module->id == 'gallery' && $_REQUEST['gallerycode'] == 1
			),
			array(
				'label'=>CHtml::image(Yii::app()->baseUrl.'/images/gallery.png').' Covers',
				'url'=>Yii::app()->getModule('gallery')->getAdminRoute("models", $model->id, "/agency/models/admin/index",2),
				'active'=>$controller->module->id == 'gallery' && $_REQUEST['gallerycode'] == 2
			),
			array(
				'label'=>CHtml::image(Yii::app()->baseUrl.'/images/video.png').' Video',
				'url'=>$controller->createUrl('/agency/models/admin/video',array('model_id'=>$model->id)),
				'active'=>$controller->action->id == 'video'
			)
		);
		$controller->menu = $menu;
	}
	
	public static function setModelsRequestsUpdateMenu($model)
	{
		$controller = Yii::app()->controller;
		$menu = array(
			array(
				'label'=>'Update Request',
				'url'=>$controller->createUrl('/agency/models/adminRequests/update',array('id'=>$model->id)),
				'active'=>$controller->action->id == 'update'
			),
			array(
				'label'=>CHtml::image(Yii::app()->baseUrl.'/images/gallery.png').' Images',
				'url'=>$controller->createUrl('/agency/models/adminRequests/images',array('request_id'=>$model->id)),
				'active'=>$controller->action->id == 'images'
			),
		);
		$controller->menu = $menu;
	}
	
	public static function createMinibook($model_id, $type)
	{
		Yii::import('application.vendors.*'); //import MPDF
		Yii::app()->getModule('gallery'); // get gallery module
		include_once('MPDF54/mpdf.php');
		//include_once('html2pdf/html2pdf.class.php');		//html2pdf is good for html validating and debugging but does not work well with styles.
		$mpdf=new mPDF('utf-8', 'A4-L');
		$c = new CDbCriteria();
		$c->order = 'gallerycode ASC';
		$gallery = Gallery::model()->findAllByAttributes(array('scope'=>'models','item_id'=>$model_id),$c);
		$images = array();
		$type = $type;
		foreach($gallery as $g)	{			//creating an image array
			foreach ($g->images as $image) {
				$images[] = $image;
			}
		}
		//var_dump($images);
		$src_pair = array();
		$model = Models::model()->findByPk($model_id);
		$cnt = 0;
		$large_id = 0;
		$fullname = $model->fullname;
		foreach($images as $item) {		//detecting main image
			if ($item->main) {
				$src_large = $item->src["large"];
				$large_id = $item->id;
				break;
			}
		}
		$src_small = array();
		$src_small2 = array();
		$src_many = array();
		$cnt = 0;
				
		
		foreach($images as $item)	{
			//todo: only add "public" images to a minibook
			switch($type) {
				case 0:
					if($item->id == $large_id) continue;
					else {
						//forming 2 arrays to operate with 2nd page separately
						if(count($src_small) <= 3)  $src_small[] = $item->src["medium"];
						else $src_small2[] = $item->src["medium"];
					}
				break;
				case 1:
					$src_pair[] = $item->src["large"];
				break;
				case 2:
					if (!$item->main) $src_many[] = $item->src["medium"];
				break;
			}
			$cnt++;
		}
		//$root_d = '/home/tntuser/public_html';
		$root_d = $_SERVER['DOCUMENT_ROOT'];
		//$root_d = YiiBase::getPathOfAlias('webroot').'/..';
		
		switch($type) {
			case 0:
			default:
				$html = "<table width=\"100%\" height=\"480px\" border=\"0\" style=\"padding-top: 60px;\"> <tr>
										<td style=\"text-align: center; width:35%;\"><img src=\"".$root_d.$src_large."\"  height=\"480px\"/></td>
										<td valign=\"bottom\">";
				$html .= "<table border=\"0\" ><tr><td colspan=\"3\" align=\"center\" style=\"height: 200px; vertical-align: top;\"><p style=\"font-size:32pt; \">{$fullname}</p></td></tr>
				<tr>";
				for($i = 0; $i<=2; $i++) {
					$html .= "<td style=\"text-align: center; height: 186px;\"><img style=\"padding-left: 65px;\" src=\"".$root_d.$src_small[$i]."\"/></td>";
				}
				$html .= "</tr></table>";
				$html .= "</td></tr></table>";
				
				//I'm NOT using a function for 5x2 cells because format may change and wont be the same to type 2
				if(count($src_small2)) {
					$html .= "<pagebreak />";
					$c =  ceil(count($src_small2)/10);
					for($i = 1; $i <= $c; $i++) {
						$html .= "<p style=\"text-align: right; padding-right: 30px; font-size:30pt;\">{$fullname}</p>
						<table  width=\"100%\" border=\"0\">";
							for($j = 1; $j<=2; $j++)	{
								$html .= "<tr>";
								for($k = 1; $k <= 5; $k++) {
									$n = -1 + $k+($j-1)*5 + ($i-1)*10;		//this creates indexes for cells in order to select images from array
									$html .= "<td style=\"text-align: right; padding-right: 30px;\" width=\"20%\">";
									if($n < count($src_small2))  $html .= "<img src=\"".$root_d.$src_small2[$n]."\"/>";
									$html .= "</td>";									
								}
							$html .= "</tr>";
						}
					$html .= "</table>";
					if($n < count($src_small2) -1 ) $html .= "<pagebreak>";	
					}
					
				}
			break;
			
			case 1:$c = ceil(count($src_pair)/2);
				for($i = 1; $i <count($src_pair); $i++)	{			
					$html .= "<p style=\"text-align: right; padding-right: 65px; font-size:32pt;\">{$fullname}</p>
					<table width=\"100%\" height=\"480px\" border=\"0\"><tr>
					<td style=\"padding-right: 65px; text-align: right; width:50%;\">";
					$html .="<img src=\"".$root_d.$src_pair[$i]."\" style=\"height:480px;\" height=\"480px\"/>";
					$html .= "</td>
					<td style=\"padding-right: 65px; text-align: right; width:50%;\">";
					$html .= "<img src=\"".$root_d.$src_pair[++$i]."\" style=\"height:480px;\" height=\"480px\"/>";
					$html .= "</td>
					";
					$html .= "</tr></table>";
				}
				
			break;
			
			case 2:
				$html = '';
				if(count($src_many)) {
					$c =  ceil(count($src_many)/10);
					for($i = 1; $i <= $c; $i++) {
						$html .= "<p style=\"text-align: right; padding-right: 30px; font-size:30pt;\">{$fullname}</p>
						<table  width=\"100%\" border=\"0\">";
							for($j = 1; $j<=2; $j++)	{
								$html .= "<tr>";
									for($k = 1; $k <= 5; $k++) {
										$n = -1 + $k+($j-1)*5 + ($i-1)*10;		//this creates indexes for cells in order to select images from array
										$html .= "<td style=\"text-align: right; padding-right: 30px;\" width=\"20%\">";
										if($n < count($src_many))  $html .= "<img src=\"".$root_d.$src_many[$n]."\"/>";
										$html .= "</td>";									
									}
								$html .= "</tr>";
							}
						$html .= "</table>";
						if($n < count($src_many) -1 ) $html .= "<pagebreak>";	
					}	
				}
			break;
		}
		//var_dump($html);
		//print $html;
		/*
		try	{
			//print htmlspecialchars($html);
			//die(htmlspecialchars($html));
			$html2pdf = new HTML2PDF('L', 'A4', 'en');
			$html2pdf->pdf->SetDisplayMode('real');
			$html2pdf->writeHTML($html);
			$html2pdf->Output("$fullname".".pdf",'I');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			die();
		}
		*/
		$mpdf->WriteHTML($html);
		$mpdf->output();
	}
}