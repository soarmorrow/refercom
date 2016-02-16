<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
         'Facebook' => array(
            'client_id' => '294902044046158',
            'client_secret' => 'e62e398d048e47c645a3dd418588cc04',
            'scope' => array('email'),
        ),
        'Linkedin' => array(
            'client_id' => '756kyy1zma5yv4',
            'client_secret' => 'svKc9cwBPUnA1Wvi',
            'scope' => array('r_basicprofile','r_emailaddress'),
        ),

	)

);