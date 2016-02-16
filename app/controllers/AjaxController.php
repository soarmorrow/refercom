<?php 


class AjaxController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('ajax-auth');
	}
    
	public function postContact()
	{
		// Declare the rules for the form validation
		$rules = array(
			'name'        => 'required',
			'email'       => 'required|email',
			'description' => 'required',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{
			$data['status'] = 'success';
		}

		return Response::json($data);

	}
	/*
	*  GET Preview writer form submission
	*
	*/
	public function getPreview()
	{
		

		$req=FormRequests::find(Input::get('request_id'));
		
		$req->description = Input::get('description');
		$req->candidate_skills = Input::get('candidate_skill');
        
        $req->save();

		$request=FormRequests::find(Input::get('request_id'));
		$seeker = $request->seeker()->first()->toArray();
		$writer = $request->writer()->first()->toArray();

		$form = $request->form()->first();
		$tabs = $request->form()->first()->fields()->get();
		$fields = $request->form()->first()->fields()->get();
        
        $request = $request->get();

		$data['status'] = 'success';
		
		$data['request']=$request;
		$data['seeker']=$seeker;
		$data['writer']=$writer;
		$data['form']=$form;
		$data['tabs']=$tabs;
		$data['fields']=$fields;


		return Response::json($data);

	}
	public function postFolder()
	{
		// Declare the rules for the form validation
		$rules = array(
			'folder_name'        => 'required',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{

             

			$sf = new Submission_folder;

            $sf->folder_name = Input::get('folder_name');
            $sf->user_id =  Sentry::getUser()->id;

            if($sf->save())
             {
			  $data['status'] = 'success';
		     }
		     else
		     {
		     	$data['status'] = 'error';
		     }
		}

		return Response::json($data);

	}
	
    public function postToFolder()
	{
		// Declare the rules for the form validation
		$rules = array(
			'folder_id'        => 'required',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{

             
             $Submissionid=Input::get('request_id');
             

             if(Input::get('submission_type') == 'recommendation')
             	$sf = LinkedinRecommendation::find($Submissionid);
             else
				$sf = FormRequests::find($Submissionid);
            
          
           if(Input::get('folder_name')=="")
            $sf->folder_id = Input::get('folder_id');
           else
           {
             $sfm = new Submission_folder;

            $sfm->folder_name = Input::get('folder_name');
            $sfm->user_id =  Sentry::getUser()->id;

            $sfm->save();
            
            $sf->folder_id = $sfm->id;
           }
           
            if($sf->save())
             {
			  $data['status'] = 'success';
		     }
		     else
		     {
		     	$data['status'] = 'error';
		     }
		}

		return Response::json($data);

	}


  	public function postSubmit()
	{

		$request=FormRequests::find(Input::get('request_id'));
		$request->submission_status = 1;
		$request->status = "complete";
        $request->description = Input::get('description');
        $request->candidate_skills = Input::get('candidate_skill');
        $request->signature = str_replace( ' ' , '+' , Input::get('sign'));
		$emails = json_decode($request->recipient_email,true);
		$first_name = json_decode($request->recipient_first_name,true);
		$last_name = json_decode($request->recipient_last_name,true);
		$user   = Sentry::getUser(); 
		$data['user'] = $user->first_name.' '.$user->last_name;

		if(!empty($emails))
		{
		$link = Input::get('pdf');
          
          $i=0;
		foreach ($emails as $email => $value) {


			$mailid = $value;
			$first_name=$first_name['first_name_r_'.$i];
			$last_name=$first_name['last_name_r_'.$i];
		   
			Mail::send('emails.form.newsubmission', compact('request','link','first_name','last_name','data'), function($message) use ($mailid,$user)
			{
				$message->from( 'noreply@myserver.com' , 'REFERECOM');
				$message->to($mailid)->subject('Referecom: '.$user->first_name.''.$user->last_name.' has finished a letter for you!');
			});


			$i++;

		}
        }
		if ($request->save())
		{
			$data['status'] = 'success';

			$form = Forms::find(Input::get('form_id'));

		/*	$timeline= new Timeline;
            $user = Sentry::getUser()->id;
			$timeline->activity_type= 'submit-form';
			$timeline->form_ops = $form->id;
            $timeline->user_id = $user;
			$timeline->save();*/
			
		}
		else{
			$data['status'] = 'error';
		
		}

		return Response::json($data);

	}
	

	
	public function postShare()
	{
		$rules = array(
			'shareEmail'       => 'required|email',
			
		);

         
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{
			
			$data['status'] = 'success';
		

			$to = Input::get( 'shareEmail');
			
			$request=FormRequests::find(Input::get('request_id'));
			$seeker = $request->seeker()->first()->toArray();
			$writer = $request->writer()->first()->toArray();

			$form = $request->form()->first();
			$tabs = $request->form()->first()->fields()->get();
			$fields = $request->form()->first()->fields()->get();

			$from = $request->writer_email;

			define('BUDGETS_DIR', public_path('uploads')); // I define this in a constants.php file

			if (!is_dir(BUDGETS_DIR)){
			    mkdir(BUDGETS_DIR, 0755, true);
			}

			$outputName = str_random(10); // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
			$pdfPath = BUDGETS_DIR.'/'.$outputName.'.pdf';
			File::put($pdfPath, PDF::load(View::make('pdf.submission', compact('request' , 'seeker' , 'writer' , 'form' , 'tabs' , 'fields') ), 'A4', 'portrait')->output());

			$data['writer_email'] = $request->writer_email;
			$data['seeker_name'] = $seeker['first_name'].' '.$seeker['last_name']. '( '.$request->seeker_email.' )';

            $link = Input::get('pdf');
			Mail::send('emails.form.writer_share', compact('data','link'), function($message) use ($pdfPath , $from , $to ){
			    $message->from( 'noreply@myserver.com' , 'REFERECOM');
			    $message->to( $to  )->subject('Letter from Referecom');
			    $message->attach($pdfPath);
			});

				$data['status'] = 'success';

				$user = Sentry::getUser()->id;

				$timeline= new Timeline;

				$timeline->activity_type = 'share-Form';
				$timeline->form_ops = $request->form_id;
				$timeline->user_id = $user;
				$timeline->shared_email = Input::get( 'shareEmail');
				$timeline->save();

			
				

        }
		return Response::json($data);

	}
    
    public function postOcrShare()
	{
		$rules = array(
			'shareEmail'       => 'required|email',
			
		);

         
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{
			
			$data['status'] = 'success';
		

			$to = Input::get( 'shareEmail');
			
			$request=Ocr::find(Input::get('request_id'));
		

			

			define('BUDGETS_DIR', public_path('uploads')); // I define this in a constants.php file

			if (!is_dir(BUDGETS_DIR)){
			    mkdir(BUDGETS_DIR, 0755, true);
			}

			$outputName = str_random(10); // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
			$pdfPath = BUDGETS_DIR.'/'.$outputName.'.pdf';
		
            $link = Input::get('pdf');
			Mail::send('emails.form.ocr_share', compact('link'), function($message) use ($pdfPath, $to ){
			    $message->from( 'noreply@myserver.com' , 'REFERECOM');
			    $message->to( $to  )->subject('Letter from Referecom');
			});

				$data['status'] = 'success';

				$user = Sentry::getUser()->id;

				$timeline= new Timeline;

				$timeline->activity_type = 'share-Form';
				$timeline->form_ops = $request->id;
				$timeline->user_id = $user;
				$timeline->shared_email = Input::get( 'shareEmail');
				$timeline->save();

			
				

        }
		return Response::json($data);

	}
      public function postPdfShare()
	{
		$rules = array(
			'shareEmail'       => 'required|email',
			
		);

         
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{
			
			$data['status'] = 'success';
		

			$to = Input::get( 'shareEmail');
			
			$request=Pdf::find(Input::get('request_id'));
		

			

			define('BUDGETS_DIR', public_path('uploads')); // I define this in a constants.php file

			if (!is_dir(BUDGETS_DIR)){
			    mkdir(BUDGETS_DIR, 0755, true);
			}

			$outputName = str_random(10); // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
			$pdfPath = BUDGETS_DIR.'/'.$outputName.'.pdf';
		
            $link = Input::get('pdf');
			Mail::send('emails.form.ocr_share', compact('link'), function($message) use ($pdfPath, $to ){
			    $message->from( 'noreply@myserver.com' , 'REFERECOM');
			    $message->to( $to  )->subject('Letter from Referecom');
			    $message->attach($pdfPath);
			});

				$data['status'] = 'success';

				$user = Sentry::getUser()->id;

				$timeline= new Timeline;

				$timeline->activity_type = 'share-Form';
				$timeline->form_ops = $request->id;
				$timeline->user_id = $user;
				$timeline->shared_email = Input::get( 'shareEmail');
				$timeline->save();

			
				

        }
		return Response::json($data);

	}
	      public function postRecommendShare()
	{
		$rules = array(
			'shareEmail'       => 'required|email',
			
		);

         
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{
			
			$data['status'] = 'success';
		

			$to = Input::get( 'shareEmail');
			
			$request=Pdf::find(Input::get('request_id'));
		

			

			define('BUDGETS_DIR', public_path('uploads')); // I define this in a constants.php file

			if (!is_dir(BUDGETS_DIR)){
			    mkdir(BUDGETS_DIR, 0755, true);
			}

			$outputName = str_random(10); // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
			$pdfPath = BUDGETS_DIR.'/'.$outputName.'.pdf';
		
            $link = Input::get('pdf');
			Mail::send('emails.form.ocr_share', compact('link'), function($message) use ($pdfPath, $to ){
			    $message->from( 'noreply@myserver.com' , 'REFERECOM');
			    $message->to( $to  )->subject('Letter from Referecom');
			    $message->attach($pdfPath);
			});

				$data['status'] = 'success';

				$user = Sentry::getUser()->id;

				$timeline= new Timeline;

				$timeline->activity_type = 'share-Form';
				$timeline->form_ops = $request->id;
				$timeline->user_id = $user;
				$timeline->shared_email = Input::get( 'shareEmail');
				$timeline->save();

			
				

        }
		return Response::json($data);

	}


	public function postFolderShare()
	{
		$rules = array(
			'shareEmail'       => 'required|email',
			
		);

         
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{
			
			$data['status'] = 'success';
		

			$to = Input::get( 'shareEmail');
			
			$request=FormRequests::find(Input::get('request_id'));
			 $seeker = $request->seeker()->first();
			 $writer = $request->writer()->first();

			//$form = $request->form()->first();
			//$tabs = $request->form()->first()->fields()->get();
			//$fields = $request->form()->first()->fields()->get();

			$from = $request->writer_email;

			define('BUDGETS_DIR', public_path('uploads')); // I define this in a constants.php file

			if (!is_dir(BUDGETS_DIR)){
			    mkdir(BUDGETS_DIR, 0755, true);
			}

			$outputName = str_random(10); // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
			$pdfPath = BUDGETS_DIR.'/'.$outputName.'.pdf';
			//File::put($pdfPath, PDF::load(View::make('pdf.submission'), 'A4', 'portrait')->output());

			$data['writer_email'] = $request->writer_email;
			$data['seeker_name'] = $seeker['first_name'].' '.$seeker['last_name']. '( '.$request->seeker_email.' )';

            $link = Input::get('pdf');
			Mail::send('emails.form.folder_share', compact('data','link'), function($message) use ($pdfPath , $from , $to ){
			    $message->from( 'noreply@myserver.com' , 'Infographics');
			    $message->to( $to  )->subject('Letter from Infographics');
			  //  $message->attach($pdfPath);
			});

				$data['status'] = 'success';


			
				

        }
		return Response::json($data);

	}
  
	public function postSeeker(){

		$get = Input::all();
        
		// Declare the rules for the form validation
		$rules = array(
			'seeker_email' => 'required|email',
			'know_from' => 'required',
			'know_to' => 'required'
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make( $get , $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails() || Input::get('know_from') == '' || Input::get('know_to') == '')
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{

			$request = FormRequests::find(Input::get('request_id'));
			$request->seeker_email = Input::get('seeker_email');

			$seeker = $request->seeker()->first();

			$seeker->know_from = $get['know_from'].' 00:00:00';
			$seeker->know_to = $get['know_to'].' 23:59:59';
			$seeker->confirm = 1;

			try{

   				$request->save(); 
   				$seeker->save();
   			}
			catch(\Exception $e)
			{
				//failed logic here
				DB::rollback();

				$data['status'] = 'error';

				return Response::json($data);
			}

			DB::commit();

			$data['status'] = 'success';

		}

		return Response::json($data);
	}

	public function postWriter(){
       
		$get = Input::all();
	
		// Declare the rules for the form validation
		$rules = array(
			'writer_email' => 'required|email',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make( $get , $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{

			$request = FormRequests::find(Input::get('request_id'));
			$request->writer_email = Input::get('writer_email');

			if( $writer_user = User::where('email' , Input::get( 'writer_email' ) )->first() )
				$request->writer_id = $writer_user->id;
			else
				$request->writer_id = 0;

			$writer = $request->writer()->first();

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
			$writer->confirm = 1;

			try{

   				$request->save(); 
   				$writer->save();
   			}
			catch(\Exception $e)
			{
				//failed logic here
				DB::rollback();

				$data['status'] = 'error';

				return Response::json($data);
			}

			DB::commit();

			$data['status'] = 'success';

		}

		return Response::json($data);
	}

	public function postFields(){

		$form = Forms::where( 'id' , Input::get('form_id'))->where('status' , 'active')->first();

		$request = FormRequests::find(Input::get('request_id'));

		$seeker = $request->seeker()->first();
		$seeker->rank = Input::get('rank');
		$seeker->save();

		$tabs = $form->tabs()->get();
		$fields = $form->fields()->get();

		$rules = array();

		foreach($fields as $f){
			$rules['name_'.$f->id ] = $f->validation;
		}

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{

			$get = Input::except('_token', 'request_id' , 'form_id' , 'rank' );

		
			DB::beginTransaction(); //Start transaction!


			try{
             
   				foreach( $get as $id => $value){

   					if( !$field = FormSubmissions::where('request_id' , Input::get('request_id') )->where( 'field_id' , (int)str_replace( 'name_' , '' , $id ) )->first()){
   						$field = new FormSubmissions;
   						$field->request_id = Input::get('request_id');
   						$field->field_id = (int)str_replace('name_' , '' , $id );
   						$field->type = 'text';

                         
   					}

   					if(is_array($value))
   					{
                      $field->option = json_encode($value);

   					}
   					else
   					{

   					$field->option = $value;	
   					}
                    
   					$field->save();

   				 $field_id =	(int)str_replace('name_' , '' , $id );
                 $form_field =  FormFields::find($field_id);

   	              $uid=$this->_generateId();
   			      $form_field->unique_id = $uid;
   			      $form_field->save();

				}
			}
			catch(\Exception $e)
			{
				//failed logic here
				DB::rollback();

				$data['status'] = 'error';

				return Response::json($data);
			}

			DB::commit();
			
			$data['status'] = 'success';
		}

		return Response::json($data);
	}
	public function editLetterName()
	{
		// Declare the rules for the form validation
		$rules = array(
			'rname'        => 'required',
		
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{
			$form_id = Input::get('form_id');
			$form = Forms::where('id',$form_id)->first();
			$form->name = Input::get('rname');
			
			if($form->save())
			{
               	$data['status'] = 'success';
		 	}
		 	else
		 	{  
		 	   $data['status'] = 'error';	
		 	}

		}

		return Response::json($data);

	}
	public function editFolderName()
	{
		// Declare the rules for the form validation
		$rules = array(
			'rname'        => 'required',
		
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{
			$folder_id = Input::get('folder_id');
			$folder = Submission_folder::where('id',$folder_id)->first();
			$folder->folder_name = Input::get('rname');
			
			if($folder->save())
			{
               	$data['status'] = 'success';
		 	}
		 	else
		 	{  
		 	   $data['status'] = 'error';	
		 	}

		}

		return Response::json($data);

	}
	/* getSeeker first Name and Last Name for linkedin dashboard timeline
	 *
	 *
	 */
	public function getSeeker()
	{
        $writer = FormWriterDetails::where('form_request_id',Input::get('requestid'))->first();
        $writer = json_decode($writer,true);

        if(!is_null($writer))
        {
        	$data['status'] = 'success';
        	$data['first_name'] = $writer['first_name'];
        	$data['last_name'] = $writer['last_name'];
        }
        else{
        	$data['status'] = 'error';	
        }
        return Response::json($data);

	}
    
    public function getSkillScore()
    {

       $code = Input::get('code');

       $field=FormFields::where('unique_id',$code)->first();
       
       $form_id = $field->form_id;  
       
       $request = FormRequests::where('form_id',$form_id)->first();

       $request_id = $request->id;


       $writer = FormWriterDetails::where('form_request_id',$request_id)->first();

       $writer_name = $writer->first_name.' '.$writer->last_name;

       $submission = FormSubmissions::where('field_id',$field->id)->first();

       $option = $submission->option;

       $option = json_decode($option,true);

       $score = $option[0];

       $year = $option[1];

       $data['status'] = 'success';
       $data['score'] = $score;
       $data['year'] = $year;

       $data['writer'] =$writer_name;
       
       return Response::json($data); 


    }
    public function getDone(){
    	$leftout = array();
    	$k=0;
    	for ($i=1; $i < Input::get('count'); $i++) { 


    		$code = Input::get('skill_'.$i);


    		$field=FormFields::where('unique_id',$code)->first();

    		if(!is_null($field)){

    			$form_id = $field->form_id;  

    			$form = Forms::find($form_id);

    			$form->to_org = "1";

    			$form->job_form_id = Input::get('job_form_id');
                
                $form->save();

                $data['status'] = 'success'; 
                $k++;
                 $data['k'] = $k;
    		}
    		else
    		{

    			array_push($leftout,$code);

    			$data['leftout'] = $leftout;
    			 $data['k'] = $k;
    		}

    	}
         if($k==0)
         {
         	  $data['status'] = 'error'; 
         	  $data['k'] = $k;
         }

    	return Response::json($data); 

    }


    // HELPER FUNCTIONS  //

	private function _generateId(){

		$id = str_random(10);
		if(!FormFields::where('unique_id', $id )->get()->isEmpty())
			return $this->_generateId();
		return $id;
	}
}