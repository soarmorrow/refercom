<?php

class FormTabs extends Eloquent {

	protected $table = 'form_tabs';

	public function fields()
	{
		return $this->hasMany('FormFields' , 'form_tab_id' );
	}

}