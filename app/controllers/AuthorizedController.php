<?php

class AuthorizedController extends BaseController {

	/**
	 * Whitelisted auth routes.
	 *
	 * @var array
	 */
	protected $whitelist = array();

	/**
	 * Initializer.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Apply the auth filter
		$this->beforeFilter('auth', array('except' => $this->whitelist));


		// if(Sentry::check()){
		// 	$user = Sentry::getUser();

		// 	$user->admin = false;
		// 	$user->organisation = false;

		// 	if($user->hasAccess('admin'))
		// 		$user->admin = true;
		// 	if($user->hasAccess('organization'))
		// 		$user->organization = true;

		// 	View::share('user' , $user);
		// }

		// Call parent
		parent::__construct();
	}

}
