<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Lang;
use View;
use FormRequests;
use Sentry;

class RequestController extends AuthorizedController {	

	public function getAllRequests(){

		$requests = FormRequests::where('seeker_id' , Sentry::getUser()->id )->get();
		$organization=Sentry::getUser()->hasAccess('organization'); 
		// Show the page
		return View::make('frontend/forms/requests' , compact('requests','organization'));
	}

	public function getRequests($id = null){

		$requests = FormRequests::where('form_id' , $id )->get();
		 $organization=Sentry::getUser()->hasAccess('organization'); 
		// Show the page
		return View::make('frontend/forms/requests' , compact('requests','organization'));
	}
}