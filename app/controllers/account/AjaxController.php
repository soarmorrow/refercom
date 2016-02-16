<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Response;
use Validator;
use FormFields;
use Forms;
use FormRequests;
use Mail;
use File;
use PDF;
use View;
use Timeline;
use Sentry;



class AjaxController extends AuthorizedController {

	/**
	 * Initializer.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Apply the admin auth filter
		$this->beforeFilter('ajax-auth');
	}


	
	public function postName()
	{
		// Declare the rules for the form validation
		$rules = array(
			'formName'        => 'required',
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



			$form = Forms::find(Input::get('form_id'));
			$form->name =Input::get('formName') ;
			$form->description =Input::get('description') ;

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
	public function postForm()
	{
		

   		$form = Forms::find(Input::get('form_id'));

		$form->status =Input::get('status') ;


		if($form->save())
		{ 
			$data['status'] = 'success';

			
			$form = Forms::find(Input::get('form_id'));
        
            $timeline= new Timeline;
            $user = Sentry::getUser()->id;  
			$timeline->activity_type= 'new-form';
			$timeline->form_ops = $form->id;
            $timeline->user_id = $user;
			$seeker = Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name;  
	        $timeline->seeker = $seeker;
			$timeline->save();

		}
		else
		{
			$data['status'] = 'error';
		}

		

		return Response::json($data);

	}
    public function DeleteFormId()
    {

    
       
            $form=FormFields::where('form_id',Input::get('form'))->delete();
             
            if($form)
            {
				$data['status'] = 'success';
			 }
			 else
			 {
			 	$data['error'] = 'error';
			 } 
    	
		return Response::json($data);

    }
	public function postNewForm()
	{
		
		// Declare the rules for the form validation
		
		$rules = array(
			'label'=>'required',
			'form_tab_id'  => 'required',
			'type' => 'required',
			);

		// Create a new validator instance from our validation rules
		$validator = Validator::make( Input::all() , $rules );
       
       
		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			$data['status'] = 'error';
			$data['errors'] = $validator->messages()->toArray();
		}
		else{

			$field = new FormFields;
			$field->form_id = Input::get('form');
			$field->label = Input::get('label');
      
			$validation = '';

			if(Input::get('required') == 1)
				$validation = 'required|';

			if(Input::get('readonly') == 1)
				$options['readonly'] ='yes';

                 //$validation .= Input::get('validation').'|';

			$field->validation = $validation;
			$field->type = Input::get('type');
			$options = array();
			switch(Input::get('type')){
				case 'textfield':
				//$options['min-length'] = Input::get('min-length');
				//$options['max-length'] = Input::get('max-length');
				$field->placeholder = Input::get('placeholder');
				break;
				case 'textarea':
				$options['rows'] = Input::get('rows');
				$field->placeholder = Input::get('placeholder');
				break;
				case 'checkbox':


				$option = Input::get('option');
				$value = Input::get('value');

				$op = array();
				for($i = 0 ; $i < count($option) ; $i++){
					$d = array( $option[$i] => $value[$i] );
					if($option[$i] != "" )
						array_push($op, $d);
				}
				$options = $op;
				break;
				case 'dropdown':

				$option = Input::get('option');
				$value = Input::get('value');

				$op = array();
				for($i = 0 ; $i < count($option) ; $i++){
					$d = array( $option[$i] => $value[$i] );
					if($option[$i] != "" )
						array_push($op, $d);
				}
				$options = $op;
				break;
				case 'multiselect':

				$option = Input::get('option');
				$value = Input::get('value');

				$op = array();
				for($i = 0 ; $i < count($option) ; $i++){
					$d = array( $option[$i] => $value[$i] );
					if($option[$i] != "" )
						array_push($op, $d);
				}
				$options = $op;
				break;
				case 'radiobutton':

				$option = Input::get('option');
				$value = Input::get('value');

				$op = array();
				for($i = 0 ; $i < count($option) ; $i++){
					$d = array( $option[$i] => $value[$i] );
					if($option[$i] != "" )
						array_push($op, $d);
				}
				$options = $op;
				break;

			}

			$field->options = json_encode($options);
             
            
            	if($field->save()){
				$data['id'] = $field->id;
				$data['status'] = 'success';
			    }
			    else{
				$data['status'] = 'error';
			    }
            

			

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
			$request=FormRequests::find(Input::get('request_id'))->first();
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

            

			Mail::send('emails.form.writer_share', compact('data'), function($message) use ($pdfPath , $from , $to ){
				$message->from( 'noreply@myserver.com' , 'REFERECOM');
				$message->to( $to  )->subject('Letter from RFERECOM');
				$message->attach($pdfPath);
			});

			if ($request->save())
			{
				$data['status'] = 'success';


				
				$user = Sentry::getUser()->id;

				$timeline= new Timeline;

				$timeline->activity_type = 'share-form';
				$timeline->form_ops = $request->form_id;
				$timeline->user_id = $user;
				$timeline->shared_email = Input::get( 'shareEmail');
				$timeline->save();

				
			}
			else{
				$data['status'] = 'error';

			}
		}
		return Response::json($data);

	}



}