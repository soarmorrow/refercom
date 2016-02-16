<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Lang;
use View;
use FormRequests;
use Sentry;
use Ocr;
use Submission_folder;
use LinkedinRecommendation;
use Pdf;
use FormSubmissions;
use Redirect;
use Forms;
use FormFields;
use Response;
use Mail;

class SubmissionController extends AuthorizedController {	

	public function getAllSubmissions(){

		$requests = FormRequests::with('writer')->where('seeker_id' , Sentry::getUser()->id )->where( 'submission_status' , 0 )->get();
        
        
		$submissions = FormRequests::where('seeker_id' , Sentry::getUser()->id )->where( 'submission_status' , 1 )->get();

        $folder =  Submission_folder::where('user_id' , Sentry::getUser()->id )->get();

        $ocr = Ocr::where('user_id' , Sentry::getUser()->id )->get(); 

        $pdf = Pdf::where('user_id' , Sentry::getUser()->id )->get(); 

        $organization=Sentry::getUser()->hasAccess('organization');

        $recommendations = LinkedinRecommendation::where('user_id' , Sentry::getUser()->id )->get();

		return View::make('frontend/forms/submissions' , compact('requests','ocr','folder','organization' , 'recommendations' , 'submissions','pdf'));
	}

	public function getSubmissions($id = null){

		$requests = FormRequests::where('seeker_id' , Sentry::getUser()->id )->where( 'submission_status' , 0 )->get();

		$submissions = FormRequests::where('form_id' , $id )->where( 'submission_status' , 1 )->get();
		 
		$folder =  Submission_folder::where('user_id' , Sentry::getUser()->id )->get();
         
        $ocr = Ocr::where('user_id' , Sentry::getUser()->id )->get(); 
        
        $pdf = Pdf::where('user_id' , Sentry::getUser()->id )->get(); 

        $recommendations = LinkedinRecommendation::where('user_id' , Sentry::getUser()->id )->get();

        $organization=Sentry::getUser()->hasAccess('organization');

		return View::make('frontend/forms/submissions' , compact('requests','ocr','folder','organization' , 'recommendations' , 'submissions','pdf'));
	}

	public function getView($id = null){

		$request = FormRequests::where('id' , $id )->where( 'submission_status' , 1 )->first();
		$seeker = $request->seeker()->first()->toArray();
		$writer = $request->writer()->first()->toArray();

		$form = $request->form()->first();
		$tabs = $request->form()->first()->fields()->get();
		$fields = $request->form()->first()->fields()->get();

        $folder =  Submission_folder::where('user_id' , Sentry::getUser()->id )->get();
        $ocr = Ocr::where('user_id' , Sentry::getUser()->id )->get(); 

        $pdf = Pdf::where('user_id' , Sentry::getUser()->id )->get(); 
        $organization=Sentry::getUser()->hasAccess('organization');
		// Show the page
		return View::make('frontend/forms/submission' , compact('request' , 'seeker' , 'writer' , 'form' , 'tabs' , 'fields','ocr','folder','organization','pdf'));
	}
	public function deleteSubmission($id=null)
	{


          $request = FormRequests::where('id',$id)->first();


   
          $request->submission_status=0;
          $request->save();

          $submission = FormSubmissions::where('request_id',$id)->get();
          
          $flag=0;
          foreach ($submission as $sub) {
              
              if($sub->delete())
              {
              	$flag=1;
              }
          }

          if($flag){
          		$success = 'submission deleted';
				// Redirect to the user page
				return Redirect::route('all/submissions')->with('success', $success);
          }

          $error = 'An error occured';
			// Redirect to the user page
			return Redirect::route('all/submissions')->with('error', $error);




	}
	 public function getPublicForm($id = null)
	{
      
   

		if($form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first()){
          
           $form = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first();

		    $formfields=FormFields::where('form_id',$form->id)->get();

            $organization=0;
			

			return Redirect::route('send/form',$form->id);
		}

		 $organization=Sentry::getUser()->hasAccess('organization'); 
		
		return Response::make(View::make('error/404'), 404);
	}

	public function getSubUpdateView($id = null){

		$organization = Sentry::getUser()->hasAccess('organization');
		$request = FormRequests::where('id',$id)->first();
	    // Show the page
		return View::make('frontend/forms/submission-update' , compact('request','organization'));
	}

	public function updateSubmission($id=null){

		
            $request = FormRequests::where('id',$id)->first();
            $form_id = $request->form_id;

            
            if(Input::get('count') > 0 || Input::get('count') != '' )
            {
            		
            	for($k=1; $k <= Input::get('count'); $k++) {
                    $field = new FormFields;
            		$field->form_id = $form_id;
            		$field->label = Input::get('skill_'.$k);
            		$field->type = 'skill';                  
                    $field->save();
            	}

            
            
                   	
            }

            $request->deadline = Input::get('deadline');
            
            if($request->save())
            {
            	$data['request_id'] = $request->id;
            	$user = Sentry::getUser();
            	$data['user'] = $user->first_name.' '.$user->last_name;

            	Mail::send('emails.form.subupdate', compact('data'), function($message) use ($request)
            	{
            		$message->from( 'noreply@myserver.com' , 'REFERECOM');
            		$message->to($request->writer_email)->subject('Letter Request from REFERECOM');
            	});



				// Prepare the success message
            	$success = 'Request sent successfully';

                 // Redirect to the user page
				return Redirect::route('all/submissions')->with('success', $success);
            }
            else
            {

            }

	}
	public function updateSubmissionEdit($id=null){
          
		$request = FormRequests::where('id',$id)->first();
		$form_id = $request->form_id;
         
         $fields = $request->form()->first()->fields()->get();
         
         foreach ($fields as $field) {
         			if($field->type == 'skill')
         			{
         				$fld = FormFields::find($field->id);
         				
         				 $fld->label=Input::get(''.$field->id);
         				if($fld->save())
         				{
                     		// Prepare the success message
         					$success = 'Request sent successfully';
         				}
         				else
         				{
         					$error = 'error occured';
         					return Redirect::route('all/submissions')->with('error', $error);
         				}
         				
         			}
         		}
                
         		$data['request_id'] = $request->id;
         		$user = Sentry::getUser();
         		$data['user'] = $user->first_name.' '.$user->last_name;

         		Mail::send('emails.form.subupdate', compact('data'), function($message) use ($request)
         		{
         			$message->from( 'noreply@myserver.com' , 'REFERECOM');
         			$message->to($request->writer_email)->subject('Letter Request from REFERECOM');
         		});
          
                 // Redirect to the user page
				return Redirect::route('all/submissions')->with('success', $success);
            
          		
			}
			public function updateSubmissionDel($id=null,$formId=null){



				$request = FormRequests::where('id',$id)->first();
				$form_id = $request->form_id;

				$fields = $request->form()->first()->fields()->get();
				$fld = FormFields::find($formId);

				if($fld->delete())
				{

			

					$success = 'Request sent successfully';
					 // Redirect to the user page
					return Redirect::back()->with('success', $success);

				}
				else{

					$error = 'Error occured';

                 // Redirect to the user page
					return Redirect::back()->with('error', $error);
				}




			}
			public function updateDelSubmission($id=null){

				$request = FormRequests::where('id',$id)->first();
				$data['request_id'] = $request->id;
				$user = Sentry::getUser();
				$data['user'] = $user->first_name.' '.$user->last_name;

				Mail::send('emails.form.subupdate', compact('data'), function($message) use ($request)
				{
					$message->from( 'noreply@myserver.com' , 'REFERECOM');
					$message->to($request->writer_email)->subject('Letter Request from REFERECOM');
				});


				$success = 'Request sent successfully';
					 // Redirect to the user page
				return Redirect::route('all/submissions')->with('success', $success);
			}

		}