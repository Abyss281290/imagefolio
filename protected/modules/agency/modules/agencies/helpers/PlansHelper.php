<?php

class PlansHelper
{
	public static function makeMonthlyCalculations()
	{
		$agency = AgencyModule::getAgency();
		if($agency && $agency->plan && $agency->payment_date && $agency->payment_date !== '0000-00-00') {
			$today = date('Y-m-d');

			if(strtotime($agency->payment_date) <= strtotime($today)) {
				
				PlansHelper::deleteOrRestoreModels();
				
				// add invoices
				if($agency->plan->price > 0) {

					// minimum payment for 1 month and maximum for 12 months


                        $date1 = new DateTime($agency->payment_date);
                        $date2 = new DateTime($today);
                        $months = min(max($date1->diff($date2)->m, 1), 12);
                        for($i=0; $i<$months; $i++){
                            self::addInvoice($agency->plan->id);
                        }
                        $agency->payment_date = date('Y-m-d', strtotime(date('Y-m').'-'.date('d',strtotime($agency->payment_date)).' +'.$months.' months'));

                        $agency->update(array('payment_date'));



				}
			}
		}
	}
	
	public function deleteOrRestoreModels($agency_id = null)
	{
		$agency = AgencyModule::getAgency($agency_id);
		$diff = $agency->models_count - $agency->plan->models_allowed;
		if($diff > 0)
		{
			// hide latest models if we have more than plan allows
			Models::model()->updateAll(
				array('deleted'=>1),
				array(
					'condition'=>'agency_id=:aid AND deleted = 0',
					'params'=>array(':aid'=>$agency->id),
					'order'=>'id DESC',
					'limit'=>$diff
				)
			);
		} else {
			// restore hidden models
			Models::model()->updateAll(
				array('deleted'=>0),
				array(
					'condition'=>'agency_id=:aid AND deleted = 1',
					'params'=>array(':aid'=>$agency->id),
					'order'=>'id ASC',
					'limit'=>+$diff
				)
			);
		}
	}
	
	public static function addInvoice($plan_id)
	{
		$plan = AgencyPlans::model()->findByPk($plan_id);
		if($plan) {
			return InvoicesHelper::addInvoice(array(
				'title'=>'Package ('.$plan->title.')',
				'description'=>'Package ('.$plan->title.') payment',
				'price'=>$plan->price
			));
		}
	}
	
	public static function renderPlanInfo()
	{
		if(Yii::app()->user->isAgencyMember()) {
			Yii::app()->controller->widget('application.modules.agency.modules.agencies.widgets.plans.PlanInfo');
		}
	}
}