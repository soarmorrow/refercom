<?php

class Forms extends Eloquent {

	protected $table = 'forms';

	protected $fillable = array('name', 'tabbed', 'description' , 'type' , 'user_id' , 'tabbed' , 'status', 'form_template_id');

	public static $rules = array(
			'name' => 'required',
			'tabbed' => 'required',
			'type' => 'required'
		);

	public function tabs()
	{
		return $this->hasMany('FormTabs' , 'form_id');
	}


	public function fields()
	{
		return $this->hasMany('FormFields' , 'form_id' );
	}

	public function requests()
	{
		return $this->hasMany('FormRequests' , 'form_id' );
	}

	public function submissions(){

		return $this->hasMany('FormRequests' , 'form_id' )->where( 'submission_status' , 1);
	}

	public function delete()
	{
		$this->tabs()->delete();

		$this->fields()->delete();

		$this->requests()->delete();

		return parent::delete();
	}

}