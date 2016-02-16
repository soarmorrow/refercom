<?php

class FormTemplateTypes extends Eloquent {

	protected $table = 'form_template_types';

	public static $rules = array(
			'name' => 'required'
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