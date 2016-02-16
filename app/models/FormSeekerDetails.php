<?php
class FormSeekerDetails extends Eloquent {

	protected $table = 'form_seeker_details';

	protected $fillable = array( 'first_name' , 'last_name' , 'address1' , 'address2' , 'address3' , 'phone' , 'mobile' , 'fax' , 'state' , 'country' , 'zip' , 'facebook' , 'twitter' , 'linkedin' , 'google' , 'google_scholar' , 'github' , 'organisation' , 'position');

	public function form()
	{
		return $this->belongsTo('FormRequests' , 'form_request_id');
	}

}