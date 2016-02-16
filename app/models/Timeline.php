<?php

class Timeline extends Eloquent {

	protected $table = 'timeline';

	public static $rules = array(
			'form_ops' => 'required',
			'activity_type' => 'required',

		);

	public function form(){
		return $this->belongsTo('Forms' , 'form_ops');
	}



}