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

                    $invoicesTotal = AgencyInvoices::getCount(AgencyModule::getCurrentAgencyId(), false);
                    $now = date('Y-m-d');
                    $now = new DateTime($now);
                    $registration = new DateTime($agency->date_registered);
                    $months = $registration->diff($now)->m;

                    $missingInvoicesCount = $months - $invoicesTotal + 1;

                    for($i=0; $i < $missingInvoicesCount; $i++){
                        self::addInvoice($agency->plan->id);
                    }
                    $checkedMonths = $months + 1;
                    $checkDate = $registration->add(new DateInterval("P{$checkedMonths}M"));
                    $agency->payment_date = $checkDate->format('Y-m-d');

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