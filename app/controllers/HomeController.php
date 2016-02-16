<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getIndex()
	{
		
		return View::make('index');
	}

    public function getpublicFolderSubmissions($id = null){

		$requests = FormRequests::where('folder_id' , $id )->where( 'submission_status' , 1 )->get();
		
		$folder = Submission_folder::find($id);
		 $organization=Sentry::getUser()->hasAccess('organization'); 
		// Show the page
		return View::make('frontend/folder_submissions' , compact('requests','folder','organization'));
	}
	

	public function getForm($id = null)
	{
       
		if($request = FormRequests::where( 'id' , $id)->where('status' , 'active')->first()){

			$seeker = $request->seeker()->first();
			$writer = $request->writer()->first();
		    $request->form_id;

			if($form = Forms::where( 'id' , $request->form_id )->where('status' , 'active')->first()){

				$tabs = $form->tabs()->get();
				$fields = $form->fields()->get();
			}

			return View::make('frontend/form' , compact('request' , 'seeker' , 'writer' , 'form' , 'tabs' , 'fields'));
		}
		
		return Response::make(View::make('error/404'), 404);
	}

    public function getPublicForm($id = null)
	{
         

		if($form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first()){
          
           $form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first();

		    $formfields=FormFields::where('form_id',$form->id)->get();

            $organization=0;
			

			return View::make('frontend/forms/new' , compact('form','formfields','organization'));
		}

		 $organization=Sentry::getUser()->hasAccess('organization'); 
		
		return Response::make(View::make('error/404'), 404);
	}
	public function getToForm($id = null)
	{
		$get = Input::all();
		if(isset($get['uniqueid']) && $get['uniqueid']){
			$id = $get['uniqueid'];
		}
       

 
         
		if($form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first()){
              
           $form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first();
              
           $today = date("m-d-Y");
           
     

           $deadline = $form->deadline;

      
        

         
            
           if($today > $deadline)
           {
            return Redirect::back()->with('error','Sorry form is no more available');           	
           }


		    $fields=FormFields::where('form_id',$form->id)->get();

            $organization=0;
			
			$skillfields = array();

            foreach ($fields as $field) {
            	foreach ($fields as $fld) {
            		if($field->placeholder == $fld->label)
            		{
            			if($fld->type= 'skill')
            			{

            			}
            		}
            	}
        }

			return View::make('frontend/forms/embed' , compact('form','fields'));
		}


		// $organization=Sentry::getUser()->hasAccess('organization'); 
		
		return Response::make(View::make('error/404'), 404);
	}
	

	public function getSuccessCopySkill($id = null)
	{
		$get = Input::all();
		if(isset($get['uniqueid']) && $get['uniqueid']){
			$id = $get['uniqueid'];
		}
       

 
         
		if($form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first()){
              
           $form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first();
              
           $today = date("m-d-Y");
     
           $deadline = $form->deadline;

          

            
           if($today > $deadline)
           {
            return Redirect::back()->with('error','Sorry form is no more available');           	
           }


		    $fields=FormFields::where('form_id',$form->id)->get();

            $organization=0;
			
			$skillfields = array();

            foreach ($fields as $field) {
            	foreach ($fields as $fld) {
            		if($field->placeholder == $fld->label)
            		{
            			if($fld->type= 'skill')
            			{

            			}
            		}
            	}
        }
          $applied_jobs = array();
         if(Sentry::check())
         {

         	$jobs_forms = Forms::where('to_org',"1")->where('status','active')->where('user_id',Sentry::getUser()->id)->get();
           
            foreach ($jobs_forms as $jobs) {
            	
            	$jform = Forms::find($jobs->job_form_id);

                $applied_jobs[$jform->name] = $jobs->updated_at;
            }
         }
         else{
              $applied_jobs =null;
         }


			return View::make('frontend/forms/skillcopysuccess' , compact('form','fields','applied_jobs'));
		}


		// $organization=Sentry::getUser()->hasAccess('organization'); 
		
		return Response::make(View::make('error/404'), 404);
	}

	public function sendMail(){
			$data['key'] = 'value';
			Mail::send('emails.test', compact('data'), function($message)
			{
				$message->from( 'noreply@myserver.com' , 'Infographics');
	    		$message->to('kt.abid@gmail.com')->subject('Letter Request');
			});
	}

	public function getOCR(){
		require_once base_path().'/vendor/thiagoalessio/tesseract_ocr/TesseractOCR/TesseractOCR.php';

		$tesseract = new TesseractOCR(public_path().'/assets/img/social/fb_login.png');
		$tesseract->setTempDir(storage_path());
		$tesseract->setLanguage('eng'); //same 3-letters code as tesseract training data packages
		echo $tesseract->recognize();
	}

	public function getEmbedForm($id=null){
          
		if($form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first()){
          
           $form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first();

		    $fields=FormFields::where('form_id',$form->id)->get();
             
           
           return View::make('frontend/forms/embed' , compact('form','fields'));

		}

        

	}

}