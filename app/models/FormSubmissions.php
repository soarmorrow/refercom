<?php

class FormSubmissions extends Eloquent {

	protected $table = 'form_submissions';

	public function request(){
		return $this->belongsTo('FormRequests' , 'request_id');
	}


}