<?php

class FormTemplates extends Eloquent {

	protected $table = 'form_templates';

	public static $rules = array(
			'name' => 'required',
			'status' => 'required',
			'tabbed' => 'required|boolean',
			'type' => 'required'
		);

	/*public function tabs()
	{
		return $this->hasMany('FormTemplateTabs');
	}

	/**
	 * Get the comment's post's.
	 *
	 * @return Blog\Post
	 */
	/*public function fields()
	{
		return $this->hasMany('FormTemplateFields');
	}*/

}