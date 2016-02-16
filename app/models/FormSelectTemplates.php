<?php

class FormSelectTemplates extends Eloquent {

	protected $table = 'form_select_templates';

	public static $rules = array(
			'name'=>'required',
			'table_name'=>'required'

			
		);



}