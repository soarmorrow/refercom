<?php

class FormFields extends Eloquent {

	protected $table = 'form_fields';

	public static $rules = array(
			'form_template_id' => 'required',
			'form_tab_id' => 'required',
			'type' => 'required',
			'label' => 'required',
			'select_template_id' => 'required',
			'options' => 'required'

		);

	public function submission(){
		return $this->hasOne('FormSubmissions' , 'field_id');
	}



}