<?php

class FormTemplateFields extends Eloquent {

	protected $table = 'form_template_fields';

	public static $rules = array(
			'form_template_id' => 'required',
			'form_tab_id' => 'required',
			'type' => 'required',
			'label' => 'required',
			'select_template_id' => 'required',
			'options' => 'required'

		);



}