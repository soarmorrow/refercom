<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Lang;
use Validator;
use View;
use Forms;
use Redirect;
use Sentry;
use FormRequests;
use Mail;
use User;
use FormSeekerDetails;
use FormWriterDetails;
use DB;
use Timeline;
use FormFields;
class FormController extends AuthorizedController {

	
	public function getIndex()
	{
		// Grab all the users
		$forms = Forms::where('user_id', Sentry::getUser()->id )->where( 'status' , '!=' , 'deleted')->orderBy('id', 'DESC')->get();
		
		$indforms =Forms::where('to_org',"1")->where( 'status' , '!=' , 'deleted')->orderBy('id', 'DESC')->get();
     
        $status = false;
       
        foreach ($forms as $f) {
        	$form_status = FormRequests::where('submission_status','=',1)->where('form_id','=',$f->id)->first();
        	if (isset($form_status['submission_status'])) {
        		$status = true;
        	}
        }
        
		$organization=Sentry::getUser()->hasAccess('organization');
         
		if($organization)
		{
		// Show the page
		return View::make('frontend/forms/index', compact('forms','organization','status','form_status','indforms'));
	    }
	    else
	    {
          
          return View::make('error/404');

	    }
	}

	public function getEdit($id = null)
	{
		
		$form = Forms::find($id);
		
		$formfields=FormFields::where('form_id',$form->id)->get();

		$organization=Sentry::getUser()->hasAccess('organization');


		// Show the page
		return View::make('frontend/forms/new' , compact('form','formfields','organization'));
	}
		public function getPostingEdit($id = null)
	{
		
		$form = Forms::find($id);
		
		$formfields=FormFields::where('form_id',$form->id)->get();

		$organization=Sentry::getUser()->hasAccess('organization');


		// Show the page
		return View::make('frontend/forms/new_posting' , compact('form','formfields','organization'));
	}
	public function getPostedEdit($id=null)
	{
       

		$form = Forms::find($id);
		
		$fields=FormFields::where('form_id',$form->id)->get();

		$organization=Sentry::getUser()->hasAccess('organization');


		// Show the page
		return View::make('frontend/forms/editpostedskills' , compact('form','fields','organization'));

	}
   
    public function getNew()
	{
		
			$form = new Forms;
			$form->name = 'New Form';
			$form->status = 'unsaved';
			$form->user_id = Sentry::getUser()->id;
			$form->unique_id = $this->_generateId();
			$form->save();

		
			return Redirect::route('edit/form', $form->id );
	}
	public function getNewPosting(){

          	$form = new Forms;
			$form->name = 'New Posting';
			$form->status = 'unsaved';
            $form->type ="posting";
			$form->user_id = Sentry::getUser()->id;
			$form->unique_id = $this->_generateId();
			$form->save();

            return Redirect::route('edit/posting', $form->id );
	}
	public function publishForm($id=null){
       
          	$form =Forms::find($id);
			$form->status = 'active';

			if($form->save()){
                return Redirect::back()->with('success','From successfully published!');
			}

		return Redirect::back()->with('error','some error occured!');
          

	}
	public function postSkills($id=null){
         
		$rules = array(
			'form_name' => 'required',
			'count' => 'required',
			'skill_1' => 'required',
			'desc_1' => 'required',
			);
		
			// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

			// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
				// Ooops.. something went wrong
			return Redirect::back()->with('error','please fill all the fields');
		}

        $form = Forms::find($id);
        $form->name = Input::get('form_name');
        $form->deadline = Input::get('deadline');
        $form->save();
        
        FormFields::where('form_id',$id)->delete();

        for ($i=1; $i <= Input::get('count'); $i++) { 
        	
        	if(Input::get('skill_'.$i) != "" && Input::get('desc_'.$i) != ""){
        		$formfield = new FormFields;
        		$formfield->form_id = $id;
        		$formfield->label = Input::get('desc_'.$i);
        		$formfield->placeholder = Input::get('skill_'.$i);
        		$formfield->type = 'embed';                  
        		$formfield->save();
        	}
        }


        $organization=Sentry::getUser()->hasAccess('organization');
        $fields=FormFields::where('form_id',$id)->get();
	
       return View::make('frontend/forms/postedskills' , compact('form','fields','organization'));
	}
	/**
	 * User create.
	 *
	 * @return View
	 */
	public function getCreate()
	{

		//$types = FormTemplateTypes::get();

		// var_dump($types);
		// Show the page
		return View::make('frontend/forms/create');
	}

	public function getArchive($id = null)
	{
          $form = Forms::find($id);
          $form->status = 'archive';
          if($form->save()){
          		$success = 'Form archived';
				// Redirect to the user page
				return Redirect::route('forms')->with('success', $success);
          }

          $error = 'An error occured';
			// Redirect to the user page
			return Redirect::route('forms')->with('error', $error);
	}

	public function getActivate($id = null)
	{
        $form = Forms::find($id);
        if($form->status != 'unsaved'){
	          $form->status = 'active';
	          if($form->save()){
	          		$success = 'Form activated';
					// Redirect to the user page
					return Redirect::route('forms')->with('success', $success);
	          }

	        $error = 'An error occured';
			// Redirect to the user page
			return Redirect::route('forms')->with('error', $error);
		}
		$error = 'Tho form is unsaved';
			// Redirect to the user page
		return Redirect::route('forms')->with('error', $error);
	}

	public function getDelete($id = null)
	{
          $form = Forms::find($id);
          $form->status = 'deleted';
          if($form->save()){
          		$success = 'Form deleted';
				// Redirect to the user page
				return Redirect::route('forms')->with('success', $success);
          }

          $error = 'An error occured';
			// Redirect to the user page
			return Redirect::route('forms')->with('error', $error);
	}

	public function getRestore($id = null)
	{

	}


	public function getSend($id = null){

		$form = Forms::get();
		$user = Sentry::getUser();

         $organization=Sentry::getUser()->hasAccess('organization');
         
         if(!$organization)
         {
          	$form = Forms::find($id);
			$form->status ='active';
			$form->save();
         }
		// Show the page
		return View::make('frontend/forms/send', compact('form' , 'user','organization'));
	}


	public function postSend($id = null){

		             //Helper Functions

		function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
			return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
		}
		function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
			return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
		}
		
       

		if( $form = Forms::find($id) ){

			$rules = array(
				'seeker_email' => 'required|email',
				'writer_email' => 'required|email',
				'form_type' => 'required',
				'deadline' => 'required',
				'recipient_email_0' => 'email'
				);

			// Create a new validator instance from our validation rules
			$validator = Validator::make(Input::all(), $rules);

			// If validation fails, we'll exit the operation now.
			if ($validator->fails())
			{
				// Ooops.. something went wrong
				return Redirect::back()->withInput()->withErrors($validator);
			}

			try
			{

				$user = Sentry::getUser();
				$get = Input::all();
			    
                // check if the writer emails are same

				$writer_count=Input::get('writer_count');
				if(Input::get('writer_count') > 0 || Input::get('writer_count') != '')
				{

					for ($i=1; $i <= $writer_count; $i++) { 
                          
                          if(Input::get( 'writer_email' ) == Input::get( 'writer_email_'.$i )){
                             
                             $error="writer emails can't be same.";
                             return Redirect::back()->with('error',$error);
                          }                          

                          for($j=2;$j <= $writer_count; $j++){
                          	if(Input::get( 'writer_email_'.$i ) == Input::get( 'writer_email_'.$j )){

                          		$error="writer emails can't be same.";
                          		return Redirect::back()->with('error',$error);
                          	}                            

                          }

					}
				}	
              
				$request = new FormRequests;
				$request->form_id = $id;
				$request->seeker_id = $user->id;
				$request->seeker_email = $user->email;

				if( $writer = User::where('email' , Input::get( 'writer_email' ) )->first() )
					$request->writer_id = $writer->id;
				else
					$request->writer_id = 0;

				$request->form_type = $get['form_type'];
				$request->relationship = $get['relationship'];
                
				$r_count=Input::get('r_count');
				if($r_count > 0 || $r_count != '')
				{
					$recipient_email = array();
					$recipient_first_name = array();
					$recipient_last_name = array();
					$recipient_organisation = array();
					$recipient_position = array();
					$recipient_address1 = array();
					$recipient_address2 = array();
					$recipient_zip = array();

					for ($i=0; $i <= $r_count; $i++) { 

						$recipient_email['recipient_email_'.$i] = $get['recipient_email_'.$i];
						$recipient_first_name['first_name_r_'.$i] = $get['first_name_r_'.$i];
						$recipient_last_name['last_name_r_'.$i] = $get['last_name_r_'.$i];
						$recipient_organisation['organisation_r_'.$i] = $get['organisation_r_'.$i];
						$recipient_position['position_r_'.$i] = $get['position_r_'.$i];
						$recipient_address1['address1_r_'.$i] = $get['address1_r_'.$i];
						$recipient_address2['address2_r_'.$i] = $get['address2_r_'.$i];
						$recipient_zip['zip_r_'.$i] = $get['zip_r_'.$i];
                    
					} 

					$request->recipient_email = json_encode($recipient_email);
					$request->recipient_first_name = json_encode($recipient_first_name);
					$request->recipient_last_name = json_encode($recipient_last_name);
					$request->recipient_organisation = json_encode($recipient_organisation);
					$request->recipient_position = json_encode($recipient_position);
					$request->recipient_address1 = json_encode($recipient_address1);
					$request->recipient_address2 = json_encode($recipient_address2);
					$request->recipient_zip = json_encode($recipient_zip);



				}   

				$request->writer_email = $get['writer_email'];
				$request->request_type = 1;
				$request->deadline = $get['deadline'].' 23:59:59';
				$request->status = 'active';
				$request->submission_status = 0;

				$seeker = new FormSeekerDetails;
				$seeker->first_name = $get['seeker_first_name'];
				$seeker->last_name = $get['seeker_last_name'];
				$seeker->address1 = $get['seeker_address1'];
				$seeker->address2 = $get['seeker_address2'];
				$seeker->address3 = $get['seeker_address3'];
				$seeker->phone = $get['seeker_phone'];
				$seeker->mobile = $get['seeker_mobile'];
				$seeker->fax = $get['seeker_fax'];
				$seeker->state = $get['seeker_state'];
				$seeker->country = $get['seeker_country'];
				$seeker->zip = $get['seeker_zip'];
				$seeker->facebook = $get['seeker_facebook'];
				$seeker->twitter = $get['seeker_twitter'];
				$seeker->linkedin = $get['seeker_linkedin'];
				$seeker->google = $get['seeker_google'];
				$seeker->google_scholar = $get['seeker_google_scholar'];
				$seeker->github = $get['seeker_github'];
				$seeker->organisation = $get['seeker_organisation'];
				$seeker->position = $get['seeker_position'];
				$seeker->confirm = 0;

				$writer = new FormWriterDetails;
				$writer->first_name = $get['first_name'];
				$writer->last_name = $get['last_name'];
				$writer->address1 = $get['address1'];
				$writer->address2 = $get['address2'];
				$writer->address3 = $get['address3'];
				$writer->phone = $get['phone'];
				$writer->mobile = $get['mobile'];
				$writer->fax = $get['fax'];
				$writer->state = $get['state'];
				$writer->country = $get['country'];
				$writer->zip = $get['zip'];
				$writer->facebook = $get['facebook'];
				$writer->twitter = $get['twitter'];
				$writer->linkedin = $get['linkedin'];
				$writer->google = $get['google'];
				$writer->google_scholar = $get['google_scholar'];
				$writer->github = $get['github'];
				$writer->organisation = $get['organisation'];
				$writer->position = $get['position'];
				$writer->confirm = 0;

				DB::beginTransaction(); //Start transaction!

				try{

   					$request->save(); 
   					$request->seeker()->save($seeker);
   					$request->writer()->save($writer);

                    //save skills for the first writer

   					foreach (Input::all() as $input => $value) {
   						if(startsWith($input,'skill_1'))
   						{
   							$formfield = new FormFields;
   							$formfield->form_id = $id;
   							$formfield->label = $value;
   							$formfield->type = 'skill';                  
   							$formfield->save();

   						}
   					}     

   					$data['request_id'] = $request->id;
   					$user = Sentry::getUser();
   					$data['user'] = $user->first_name.' '.$user->last_name;
   					$data['writer-firstname'] = $get['first_name'];
   					$data['writer-lastname'] = $get['last_name'];

   					$form = Forms::find($id);
   					$timeline= new Timeline;
   					$user = Sentry::getUser()->id;  
   					$timeline->activity_type= 'request-form';
   					$timeline->form_ops = $form->id;
   					$timeline->user_id = $user;
   					$timeline->seeker = $get['seeker_first_name'].''.$get['seeker_last_name'];
   					$timeline->writer = $get['first_name'].''.$get['last_name'];
   					$timeline->save();

				}
				catch(\Exception $e)
				{
					//failed logic here
					DB::rollback();

					var_dump($e->getMessage());exit;

				   	// Prepare the error message
					$error = 'An error occured';

					// Redirect to the user creation page
					return Redirect::back()->withInput()->with('error', $error)->withInput();
				}

				DB::commit();
				$user = Sentry::getUser();
				Mail::send('emails.form.new', compact('data'), function($message) use($user)
				{
					$message->from( 'noreply@myserver.com' , 'REFERECOM');
					$message->to(Input::get( 'writer_email' ))->subject('Referecom: '.$user->first_name.''.$user->last_name.' has requested a letter from you');
				});
                 
				$user = Sentry::getUser();
				$get = Input::all();

                $writer_count=Input::get('writer_count');
                if(Input::get('writer_count') > 0 || Input::get('writer_count') != '')
                {
                 
                	for ($i=1; $i <= $writer_count; $i++) { 
                       
                		$newForm = new Forms;
                		$newForm->name = 'New Form';
                		$newForm->status = 'unsaved';
                		$newForm->user_id = Sentry::getUser()->id;
                		$newForm->unique_id = $this->_generateId();
                		$newForm->save();

                		$newFormId = $newForm->id;

                		$request = new FormRequests;
                		$request->form_id = $newFormId;
                		$request->seeker_id = $user->id;
                		$request->seeker_email = $user->email;

                		if( $writer = User::where('email' , Input::get( 'writer_email_'.$i ) )->first() )
                			$request->writer_id = $writer->id;
                		else
                			$request->writer_id = 0;

                		$request->form_type = $get['form_type'];
                		$request->relationship = $get['relationship'];

                		$r_count=Input::get('r_count');
                		if($r_count > 0 || $r_count != '')
                		{
                			$recipient_email = array();
                			$recipient_first_name = array();
                			$recipient_last_name = array();
                			$recipient_organisation = array();
                			$recipient_position = array();
                			$recipient_address1 = array();
                			$recipient_address2 = array();
                			$recipient_zip = array();

                			for ($r=0; $r <= $r_count; $r++) { 

                				$recipient_email['recipient_email_'.$r] = $get['recipient_email_'.$r];
                				$recipient_first_name['first_name_r_'.$r] = $get['first_name_r_'.$r];
                				$recipient_last_name['last_name_r_'.$r] = $get['last_name_r_'.$r];
                				$recipient_organisation['organisation_r_'.$r] = $get['organisation_r_'.$r];
                				$recipient_position['position_r_'.$r] = $get['position_r_'.$r];
                				$recipient_address1['address1_r_'.$r] = $get['address1_r_'.$r];
                				$recipient_address2['address2_r_'.$r] = $get['address2_r_'.$r];
                				$recipient_zip['zip_r_'.$r] = $get['zip_r_'.$r];

                			} 

                			$request->recipient_email = json_encode($recipient_email);
                			$request->recipient_first_name = json_encode($recipient_first_name);
                			$request->recipient_last_name = json_encode($recipient_last_name);
                			$request->recipient_organisation = json_encode($recipient_organisation);
                			$request->recipient_position = json_encode($recipient_position);
                			$request->recipient_address1 = json_encode($recipient_address1);
                			$request->recipient_address2 = json_encode($recipient_address2);
                			$request->recipient_zip = json_encode($recipient_zip);



                		}   

                		$request->writer_email = $get['writer_email_'.$i];
                		$request->request_type = 1;
                		$request->deadline = $get['deadline'].' 23:59:59';
                		$request->status = 'active';
                		$request->submission_status = 0;

                		$seeker = new FormSeekerDetails;
                		$seeker->first_name = $get['seeker_first_name'];
                		$seeker->last_name = $get['seeker_last_name'];
                		$seeker->address1 = $get['seeker_address1'];
                		$seeker->address2 = $get['seeker_address2'];
                		$seeker->address3 = $get['seeker_address3'];
                		$seeker->phone = $get['seeker_phone'];
                		$seeker->mobile = $get['seeker_mobile'];
                		$seeker->fax = $get['seeker_fax'];
                		$seeker->state = $get['seeker_state'];
                		$seeker->country = $get['seeker_country'];
                		$seeker->zip = $get['seeker_zip'];
                		$seeker->facebook = $get['seeker_facebook'];
                		$seeker->twitter = $get['seeker_twitter'];
                		$seeker->linkedin = $get['seeker_linkedin'];
                		$seeker->google = $get['seeker_google'];
                		$seeker->google_scholar = $get['seeker_google_scholar'];
                		$seeker->github = $get['seeker_github'];
                		$seeker->organisation = $get['seeker_organisation'];
                		$seeker->position = $get['seeker_position'];
                		$seeker->confirm = 0;

                		$writer = new FormWriterDetails;
                		$writer->first_name = $get['first_name_'.$i];
                		$writer->last_name = $get['last_name_'.$i];
                		$writer->address1 = $get['address1_'.$i];
                		$writer->address2 = $get['address2_'.$i];
                
                		$writer->phone = $get['phone_'.$i];
                		$writer->mobile = $get['mobile_'.$i];
                		$writer->fax = $get['fax_'.$i];
                		$writer->state = $get['state_'.$i];
                		$writer->country = $get['country_'.$i];
                		$writer->zip = $get['zip_'.$i];
                        $writer->organisation = $get['organisation_'.$i];
                		$writer->position = $get['position_'.$i];
                		$writer->confirm = 0;
                        

                        	DB::beginTransaction(); //Start transaction!

                        	try{

                        		$request->save(); 
                        		$request->seeker()->save($seeker);
                        		$request->writer()->save($writer);
                                 //the skill number and writer number are different so +1;
                        		$skill_number = $i+1; 
                              
                              
                                
                        		foreach (Input::all() as $input => $value) {
                        			if(startsWith($input,'skill_'.$skill_number))
                        			{
                        				$formfield = new FormFields;
                        				$formfield->form_id = $newFormId;
                        				$formfield->label = $value;
                        				$formfield->type = 'skill';                  
                        				$formfield->save();

                        			}
                        		} 

                        		$data['request_id'] = $request->id;
                        		$user = Sentry::getUser();
                        		$data['user'] = $user->first_name.' '.$user->last_name;
                        		$data['writer-firstname'] = $get['first_name_'.$i];
                        		$data['writer-lastname'] = $get['last_name_'.$i];

                        		$form = Forms::find($id);
                        		$timeline= new Timeline;
                        		$user = Sentry::getUser()->id;  
                        		$timeline->activity_type= 'request-form';
                        		$timeline->form_ops = $form->id;
                        		$timeline->user_id = $user;
                        		$timeline->seeker = $get['seeker_first_name'].''.$get['seeker_last_name'];
                        		$timeline->writer = $get['first_name_'.$i].''.$get['last_name_'.$i];
                        		$timeline->save();

                        	}
                        	catch(\Exception $e)
                        	{
					           //failed logic here
                        		DB::rollback();

                        		var_dump($e->getMessage());exit;

				   	            // Prepare the error message
                        		$error = 'An error occured';

					            // Redirect to the user creation page
                        		return Redirect::back()->withInput()->with('error', $error)->withInput();
                        	}

                        	DB::commit();
                        	$user = Sentry::getUser();
                        	Mail::send('emails.form.new', compact('data'), function($message) use($i,$user)
                        	{
                        		$message->from( 'noreply@myserver.com' , 'REFERECOM');
                        		$message->to(Input::get( 'writer_email_'.$i ))->subject('Referecom: '.$user->first_name.''.$user->last_name.' has requested a letter from you');
                        	});
                	}

                }




				// Prepare the success message
				$success = 'Request sent successfully';

				// Redirect to the new user page
				return Redirect::route('all/submissions')->with('success', $success);

				
			}
			catch (Exception $e)
			{
				$error = 'An error occured';
			}
		}

		$error = 'An error occured';
		// Redirect to the user creation page
		return Redirect::back()->withInput()->with('error', $error);
	}

   public function getResend($id=null)
   {
     
      $request=FormRequests::find($id);
   					$data['request_id'] = $id;
   					$user = Sentry::getUser();
   					$data['user'] = $user->first_name.' '.$user->last_name;
   					$writer_email=$request->writer_email;
           
   					Mail::send('emails.form.new', compact('data'), function($message) use ($writer_email)
   					{
   						$message->from( 'noreply@myserver.com' , 'Infographics');
   						$message->to($writer_email)->subject('Letter Request from Infographics');
   					});

            $success = 'successfully resend request';
           return Redirect::back()->withInput()->with('success', $success);

   }




	// HELPER FUNCTIONS  //

	private function _generateId(){

		$id = str_random(10);
		if(!Forms::where('unique_id', $id )->get()->isEmpty())
			return $this->_generateId();
		return $id;
	}


}

