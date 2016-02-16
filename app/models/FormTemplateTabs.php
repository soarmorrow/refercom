<?php

class FormTemplateTabs extends Eloquent {

	protected $table = 'form_template_tabs';

	public static $rules = array(
			'form_template_id' => 'required',
			'form_template_field_id'=>'required',
			'value'=>'required',
			'option'=>'required'
		);



}