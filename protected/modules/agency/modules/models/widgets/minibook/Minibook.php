<?php

class Minibook extends CWidget
{
		public $model_id;
		public $type;
		
		private $types = array(
			0 => 'standard',
			1 => 'pairs',
			2 => 'thumbs'
		);
		
		public $mpdfOptions = array(
			'mode' => 'utf-8',
			'format' => 'A4-L',
			'fontSize' => 0,
			'fontFamily' => 'sans-serif',
			'marginLeft' => 10,
			'marginRight' => 10,
			'marginTop' => 10,
			'marginBottom' => 10,
			'marginHeader' => 0,
			'marginFooter' => 0,
			'type' => '' // L,P
		);
	
	public function init()
	{
		Yii::import('application.vendors.*'); //import MPDF
		Yii::app()->getModule('gallery'); // get gallery module
		include_once('MPDF54/mpdf.php');
		//include_once('html2pdf/html2pdf.class.php');		//html2pdf is good for html validating and debugging but does not work well with styles.
		$c = new CDbCriteria();
		$c->order = 'gallerycode ASC';
		$gallery = Gallery::model()->findByAttributes(array('scope'=>'models','item_id'=>$this->model_id,'gallerycode'=>0),$c);
		$images = array();
		$type = isset($this->types[$this->type])? $this->types[$this->type] : $this->types[0];
		$images = $gallery->imagesPublic;
		//var_dump($images);
		$src_pair = array();
		$model = Models::model()->findByPk($this->model_id);
		$cnt = 0;
		$large_id = 0;
		$fullname = $model->fullname;
		// get main image from first gallery
		$src_large = $gallery->getMainImage('large', false, $images);
		//$large_id = $item->id;
		
		$src_small = array();
		$src_small2 = array();
		$src_many = array();
		$cnt = 0;
		
		$webroot = Yii::getPathOfAlias('webroot');
		$root_d = $_SERVER['DOCUMENT_ROOT'];
		
		$address = "CA: Net Tech Engineering Limited
58 Waterloo Row
Fredericton NB, E3B 1Y9";
		$site_logo_path = $webroot.'/images/logo_models_pdf.jpg';
		
		$html = $this->render($type, array(
			'model'=>$model,
			'mainImage'=>$root_d.$gallery->getMainImage('large', false, $images),
			'images'=>$gallery->imagesPublic,
			'webroot'=>$webroot,
			'document_root'=>$root_d,
			'site_address'=>$address,
			'site_logo_path'=>$site_logo_path
		), true);
		
		$mpdf=new mPDF(
			$this->mpdfOptions['mode'],
			$this->mpdfOptions['format'],
			$this->mpdfOptions['fontSize'],
			$this->mpdfOptions['fontFamily'],
			$this->mpdfOptions['marginLeft'],
			$this->mpdfOptions['marginRight'],
			$this->mpdfOptions['marginTop'],
			$this->mpdfOptions['marginBottom'],
			$this->mpdfOptions['marginHeader'],
			$this->mpdfOptions['marginFooter'],
			$this->mpdfOptions['type']
		);
		$mpdf->WriteHTML($html);
		$mpdf->output(UrlTransliterate::cleanString($model->fullname, '_').'.pdf', 'I');
	}
}