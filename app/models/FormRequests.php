<?php
class FormRequests extends Eloquent {

	protected $table = 'form_requests';

	protected $fillable = array( 'form_id' , 'seeker_id' , 'seeker_email', 'writer_id' , 'writer_email' , 'form_type_id' , 'request_type' , 'deadline' , '');

	public function seeker()
	{
		return $this->hasOne('FormSeekerDetails' , 'form_request_id');
	}

	public function writer()
	{
		return $this->hasOne('FormWriterDetails' , 'form_request_id');
	}

	public function form(){
		return $this->belongsTo( 'Forms' , 'form_id' );
	}

	public function delete()
	{
		// Delete the details
		$this->seeker()->delete();

		// Delete the details
		$this->writer()->delete();

		// Delete the request
		return parent::delete();
	}

}