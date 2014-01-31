<?php

class InvoicesHelper
{
	/*
	InvoicesHelper::addInvoices(array(
		array(
			'title'=>'New test invoice',
			'description'=>'description of test invoice',
			'price'=>1000
		)
	));
	*/
	public static function addInvoices($invoiceItems)
	{
		$agency_id = AgencyModule::getCurrentAgencyId();
		$invoice = new AgencyInvoices();
		$invoice->agency_id = $agency_id;
		$invoice->create_time = new CDbExpression('NOW()');
		$invoice->save();
		
		foreach($invoiceItems as $item) {
			$itemModel = new AgencyInvoicesItems();
			$itemModel->attributes = $item;
			$itemModel->invoice_id = $invoice->id;
			$itemModel->save();
		}
		
		return $invoice;
	}
	
	public static function addInvoice($invoiceItem)
	{
		return self::addInvoices(array($invoiceItem));
	}
}