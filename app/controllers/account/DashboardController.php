<?php namespace Controllers\Account;

use AuthorizedController;
use Redirect;
use View;
use Sentry;
use Timeline;
use FormRequests;
use Input;
use Validator;
use Ocr;
use FormFields;
use FormSubmissions;
use Pdf;
use LinkedinRecommendation;
use Session;
use Forms;
class DashboardController extends AuthorizedController {

	/**
	 * Redirect to the profile page.
	 *
	 * @return Redirect
	 */
	public function getIndex()
	{
		
		return Redirect::route('profile');
	}
    /**
	 * Redirect to the Dashboard page.
	 *
	 * @return View
	 */
    public function getLinkedinDashboard(){
        
        $organization=Sentry::getUser()->hasAccess('organization');
        
        $linkedin = Session::get('linkedin');

        $requests = FormRequests::where('seeker_id',Sentry::getUser()->id)->where( 'submission_status' , 1 )->get();
    	

    	foreach ($requests as $req) {
			$seeker[] = $req->seeker()->get();
			$writer[] = $req->writer()->first();
		}
		$dates = array();
		$requestids = array();
        $p=0;

        foreach ($seeker as $seeker) {      
        
        $time=strtotime($seeker[0]['know_from']);
        $month=date("n",$time);
        $year=date("Y",$time);

        $dates[$p]['know_from']['month'] = $month;
        $dates[$p]['know_from']['year']  = $year;

        $time=strtotime($seeker[0]['know_to']);
        $month=date("n",$time);
        $year=date("Y",$time);

        $dates[$p]['know_to']['month'] = $month;
        $dates[$p]['know_to']['year']  = $year;

        $requestids[$p] = $seeker[0]['form_request_id'];

        $p++;
        }
    

    	return View::make('frontend/account/dashboard',compact('organization','linkedin','requests','seeker','dates','requestids'));    	
    }
    /**
	 * Save Form with fields as Linked in skills.
	 *
	 * @return Redirect to Linkedin Request route
	 */
    public function postLinkedinForm($company=null,$letter_type=null){
     
       $linkedin = Session::get('linkedin');
      


       $form = new Forms;
       $form->name = 'New Linkedin Form';
       $form->status = 'unsaved';
       $form->user_id = Sentry::getUser()->id;
       $form->unique_id = $this->_generateId();
       $form->save();

       $form_id = $form->id;

      
      if($letter_type == 'Professional')                               
       Session::put('letter_type','Professional');
      else
       Session::put('letter_type','Academic');

       

       Session::put('company',$company);

       return Redirect::route('send/form', $form_id );



    }
    /**
	 * Redirect to Request Send with the form id.
	 *
	 * @return Redirect to Request Page with the saved form id.
	 */
    public function getLinkedinSend($id){
        
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

	/**
	 * Redirect to the Timeline page.
	 *
	 * @return View
	 */
	public function getTimeline()
	{
		$timeline  = Timeline::where('user_id',Sentry::getUser()->id)->get();
		$organization=Sentry::getUser()->hasAccess('organization');         
		return View::make('frontend/timeline',compact('timeline','organization'));
	}
	/**
	 * Redirect to the Ranking page.
	 *
	 * @return View
	 */
	public function getRank($id=null)
	{
		$request = FormRequests::where('form_id' ,$id)->where( 'submission_status' , 1 )->get();

		$field=null;
		$ids = array();
		foreach ($request as $req) {
			$seeker[] = $req->seeker()->first();
			$writer[] = $req->writer()->first();

			$form[] = $req->form()->first();
			$tabs = $req->form()->first()->fields()->get();

			$field[]= $req->form()->get()->toArray();
			foreach ($field as $values) {
				foreach ($values as $value) {
					array_push($ids, (int)$value['id']);
				}
			}
		}
		$ids = array_unique($ids);
		$fields = FormFields::whereIn('form_id', $ids)->get();

		$organization=Sentry::getUser()->hasAccess('organization');         

		return View::make('frontend/rank',compact('organization','request','seeker','writer','form','tabs','fields','id'));
	}
	
	/**
	 * Redirect to the Main Ranking page with specific skills highlighted.
	 *
	 * @return View
	 */
	public function getSkillMainRank($reqid = null)
	{
		$request = FormRequests::where('seeker_id' , Sentry::getUser()->id )->where( 'submission_status' , 1 )->get();
        
        if($request == null)
        {
            return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     
        }
        if(!isset($request)){
 
           return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     
        }
        $null=0;
        foreach ($request as $req) {
          
        	if(is_null($req->id))
             {
             	$null = 1;
             }
        }
        if($null == 1){
           
           return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     

        }
  
         
        
        

		$field=null;
		$ids = array();
		foreach ($request as $req) {
			$seeker[] = $req->seeker()->first();
			$writer[] = $req->writer()->first();

			$form[] = $req->form()->first();
			$tabs = $req->form()->first()->fields()->get();

			$field[]= $req->form()->get()->toArray();
			foreach ($field as $values) {
				foreach ($values as $value) {
					array_push($ids, (int)$value['id']);
				}
			}
		}
		$ids = array_unique($ids);
		$fields = FormFields::whereIn('form_id', $ids)->get();
		$filter = $fields->toArray();
		$grouped = array();
		foreach ($filter as $arr) {
			if($arr['type'] == 'skill'){
				//var_dump(array_key_exists($arr['label'], $grouped));
				if(array_key_exists($arr['label'], $grouped)){
					array_push($grouped[$arr['label']], $arr);
				}else{
					$grouped[$arr['label']] = array();
					array_push($grouped[$arr['label']], $arr);
				}
			}
		}

		$selectedIds=array();
		foreach ($grouped as $skill => $group) {
			foreach ($group as $value) {
				if(array_key_exists($skill, $selectedIds)){
					$selectedIds[$skill][] = (int)$value['id'];
				}else{
					$selectedIds[$skill] = array();
					$selectedIds[$skill][] = (int)$value['id'];
				}      
			}
		}
		$optionArrayScore=array();
		$optionArrayYear=array();
		foreach ($selectedIds as $skill => $group) 
		{
			$submissions =  FormSubmissions::whereIn('field_id',$selectedIds[$skill])->get();
			foreach ($submissions as $f1) {
				$t=1;
				foreach(json_decode($f1->option) as $op) {
					if( $t == 1 || $t % 2 != 0)
					{
						if(array_key_exists($skill, $optionArrayScore)){
							$optionArrayScore[$skill][] = $op;
						}
						else
						{
							$optionArrayScore[$skill] = array();
							$optionArrayScore[$skill][] = $op;
						}  
					}
					else
					{
						if(array_key_exists($skill, $optionArrayYear)){
							$optionArrayYear[$skill][] = $op;
						}
						else
						{
							$optionArrayYear[$skill] = array();
							$optionArrayYear[$skill][] = $op;
						}
					}
					$t++;
				}
			}
		}
		$calculatedValue = array();
		$calculatedValueYear = array();
		$calculatedValueMscore = array();
		foreach ($optionArrayScore as $skill => $group) {
			$groupCount = count($optionArrayScore[$skill]);
			$value = 0;
			$score = 0;
			$year = 0;
			//$divider=10*$groupCount;
			for($i=0;$i < $groupCount;$i++){
				$score +=($optionArrayScore[$skill][$i]*2)*$optionArrayYear[$skill][$i];
				$year += $optionArrayYear[$skill][$i]; 
			}
			try{
				if (!$year) {

				}
				else
				{
					$calculatedValue[$skill] = $score;
					$calculatedValueYear[$skill] = $year;
					$calculatedValueMscore[$skill]=(($score/$year));
				}
			}catch(Exception $ex){
				$val = 0;
			}
		}
		$organization=Sentry::getUser()->hasAccess('organization');   


		//skill highlighting

		$skill_request = FormRequests::where('id' , $reqid )->first(); 
 
        $skill_form_id = $skill_request['form_id'];
        
        $skillfields = FormFields::where('form_id', $skill_form_id)->get();
        
        $skillfields = json_decode($skillfields,true);
        
        $markskills =array();
        foreach ($skillfields as $skills) {
            
           if($skills['type'] == 'skill'){
             
             $markskills[$skills['label']] = $skills['label'];     

           }
        	
        }


		return View::make('frontend/rank-main',compact('organization','calculatedValueMscore','request','seeker','writer','form','fields','id','grouped','calculatedValueYear','calculatedValue','markskills'));
	}
	/**
	 * Redirect to the Main Ranking page.
	 *
	 * @return View
	 */
	public function getMainRank()
	{
		$request = FormRequests::where('seeker_id' , Sentry::getUser()->id )->where( 'submission_status' , 1 )->get();
        
        if($request == null)
        {
            return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     
        }
        if(!isset($request)){
 
           return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     
        }
        $null=0;
        foreach ($request as $req) {
          
        	if(is_null($req->id))
             {
             	$null = 1;
             }
        }
        if($null == 1){
           
           return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     

        }
  
         
        
        

		$field=null;
		$ids = array();
		foreach ($request as $req) {
			$seeker[] = $req->seeker()->first();
			$writer[] = $req->writer()->first();

			$form[] = $req->form()->first();
			$tabs = $req->form()->first()->fields()->get();

			$field[]= $req->form()->get()->toArray();
			foreach ($field as $values) {
				foreach ($values as $value) {
					array_push($ids, (int)$value['id']);
				}
			}
		}
		$ids = array_unique($ids);
		$fields = FormFields::whereIn('form_id', $ids)->get();
		$filter = $fields->toArray();
		$grouped = array();
		foreach ($filter as $arr) {
			if($arr['type'] == 'skill'){
				//var_dump(array_key_exists($arr['label'], $grouped));
				if(array_key_exists($arr['label'], $grouped)){
					array_push($grouped[$arr['label']], $arr);
				}else{
					$grouped[$arr['label']] = array();
					array_push($grouped[$arr['label']], $arr);
				}
			}
		}

		$selectedIds=array();
		foreach ($grouped as $skill => $group) {
			foreach ($group as $value) {
				if(array_key_exists($skill, $selectedIds)){
					$selectedIds[$skill][] = (int)$value['id'];
				}else{
					$selectedIds[$skill] = array();
					$selectedIds[$skill][] = (int)$value['id'];
				}      
			}
		}
		$optionArrayScore=array();
		$optionArrayYear=array();
		foreach ($selectedIds as $skill => $group) 
		{
			$submissions =  FormSubmissions::whereIn('field_id',$selectedIds[$skill])->get();
			foreach ($submissions as $f1) {
				$t=1;
				foreach(json_decode($f1->option) as $op) {
					if( $t == 1 || $t % 2 != 0)
					{
						if(array_key_exists($skill, $optionArrayScore)){
							$optionArrayScore[$skill][] = $op;
						}
						else
						{
							$optionArrayScore[$skill] = array();
							$optionArrayScore[$skill][] = $op;
						}  
					}
					else
					{
						if(array_key_exists($skill, $optionArrayYear)){
							$optionArrayYear[$skill][] = $op;
						}
						else
						{
							$optionArrayYear[$skill] = array();
							$optionArrayYear[$skill][] = $op;
						}
					}
					$t++;
				}
			}
		}
		$calculatedValue = array();
		$calculatedValueYear = array();
		$calculatedValueMscore = array();
		foreach ($optionArrayScore as $skill => $group) {
			$groupCount = count($optionArrayScore[$skill]);
			$value = 0;
			$score = 0;
			$year = 0;
			//$divider=10*$groupCount;
			for($i=0;$i < $groupCount;$i++){
				$score +=($optionArrayScore[$skill][$i]*2)*$optionArrayYear[$skill][$i];
				$year += $optionArrayYear[$skill][$i]; 
			}
			try{
				if (!$year) {

				}
				else
				{
					$calculatedValue[$skill] = $score;
					$calculatedValueYear[$skill] = $year;
					$calculatedValueMscore[$skill]=(($score/$year));
				}
			}catch(Exception $ex){
				$val = 0;
			}
		}
		$organization=Sentry::getUser()->hasAccess('organization');  

		$markskills = null;       

		return View::make('frontend/rank-main',compact('organization','calculatedValueMscore','request','seeker','writer','form','fields','id','grouped','calculatedValueYear','calculatedValue','markskills'));
	}
		public function getToFormloggedin($id = null)
	{
		$get = Input::all();
		if(isset($get['uniqueid']) && $get['uniqueid']){
			$id = $get['uniqueid'];
		}
       

 
         
		if($uniqueform = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first()){
              
           $uniqueform = Forms::where( 'unique_id' , $id)->where('status' , 'active')->first();
              
           $today = date("m-d-Y");

           $deadline = $uniqueform->deadline;

            
           if($today > $deadline)
           {
            return Redirect::back()->with('error','Sorry form is no more available');           	
           }

             $uniquefields=FormFields::where('form_id',$uniqueform->id)->get();

       
			
			$skillfields = array();

            foreach ($uniquefields as $ufield) {
            	foreach ($uniquefields as $fld) {
            		if($ufield->placeholder == $fld->label)
            		{
            			if($fld->type= 'skill')
            			{

            			}
            		}
            	}
        }


		   

    

        //main-ranking

        $request = FormRequests::where('seeker_id' , Sentry::getUser()->id )->where( 'submission_status' , 1 )->get();
        
        if($request == null)
        {
            return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     
        }
        if(!isset($request)){
 
           return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     
        }
        $null=0;
        foreach ($request as $req) {
          
        	if(is_null($req->id))
             {
             	$null = 1;
             }
        }
        if($null == 1){
           
           return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     

        }
  
         
        
        

		$field=null;
		$ids = array();
		foreach ($request as $req) {
			$seeker[] = $req->seeker()->first();
			$writer[] = $req->writer()->first();

			$form[] = $req->form()->first();
			$tabs = $req->form()->first()->fields()->get();

			$field[]= $req->form()->get()->toArray();
			foreach ($field as $values) {
				foreach ($values as $value) {
					array_push($ids, (int)$value['id']);
				}
			}
		}

		$ids = array_unique($ids);
		$fields = FormFields::whereIn('form_id', $ids)->get();
		$filter = $fields->toArray();
		$grouped = array();
		foreach ($filter as $arr) {
			if($arr['type'] == 'skill'){
				//var_dump(array_key_exists($arr['label'], $grouped));
				if(array_key_exists($arr['label'], $grouped)){
					array_push($grouped[$arr['label']], $arr);
				}else{
					$grouped[$arr['label']] = array();
					array_push($grouped[$arr['label']], $arr);
				}
			}
		}


		$selectedIds=array();
		foreach ($grouped as $skill => $group) {
			foreach ($group as $value) {
				if(array_key_exists($skill, $selectedIds)){
					$selectedIds[$skill][] = (int)$value['id'];
				}else{
					$selectedIds[$skill] = array();
					$selectedIds[$skill][] = (int)$value['id'];
				}      
			}
		}


		$optionArrayScore=array();
		$optionArrayYear=array();
		foreach ($selectedIds as $skill => $group) 
		{
			$submissions =  FormSubmissions::whereIn('field_id',$selectedIds[$skill])->get();
			foreach ($submissions as $f1) {
				$t=1;
				foreach(json_decode($f1->option) as $op) {
					if( $t == 1 || $t % 2 != 0)
					{
						if(array_key_exists($skill, $optionArrayScore)){
							$optionArrayScore[$skill][] = $op;
						}
						else
						{
							$optionArrayScore[$skill] = array();
							$optionArrayScore[$skill][] = $op;
						}  
					}
					else
					{
						if(array_key_exists($skill, $optionArrayYear)){
							$optionArrayYear[$skill][] = $op;
						}
						else
						{
							$optionArrayYear[$skill] = array();
							$optionArrayYear[$skill][] = $op;
						}
					}
					$t++;
				}
			}
		}

		$calculatedValue = array();
		$calculatedValueYear = array();
		$calculatedValueMscore = array();
		foreach ($optionArrayScore as $skill => $group) {
			$groupCount = count($optionArrayScore[$skill]);
			$value = 0;
			$score = 0;
			$year = 0;
			//$divider=10*$groupCount;
			for($i=0;$i < $groupCount;$i++){
				$score +=($optionArrayScore[$skill][$i]*2)*$optionArrayYear[$skill][$i];
				$year += $optionArrayYear[$skill][$i]; 
			}
			try{
				if (!$year) {

				}
				else
				{
					$calculatedValue[$skill] = $score;
					$calculatedValueYear[$skill] = $year;
					$calculatedValueMscore[$skill]=(($score/$year));
				}
			}catch(Exception $ex){
				$val = 0;
			}
		}

		$organization=Sentry::getUser()->hasAccess('organization');  

		$markskills = null;       
    
		return View::make('frontend/rank-main',compact('organization','calculatedValueMscore','request','seeker','writer','form','fields','id','grouped','calculatedValueYear','calculatedValue','markskills','uniqueform','uniquefields'));

			
		}
        else
        {

        	//main-ranking

        $request = FormRequests::where('seeker_id' , Sentry::getUser()->id )->where( 'submission_status' , 1 )->get();
        
        if($request == null)
        {
            return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     
        }
        if(!isset($request)){
 
           return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     
        }
        $null=0;
        foreach ($request as $req) {
          
        	if(is_null($req->id))
             {
             	$null = 1;
             }
        }
        if($null == 1){
           
           return Redirect::back()->with('error', 'There should be atleast one form submission by a writer');     

        }
  
         
        
        

		$field=null;
		$ids = array();
		foreach ($request as $req) {
			$seeker[] = $req->seeker()->first();
			$writer[] = $req->writer()->first();

			$form[] = $req->form()->first();
			$tabs = $req->form()->first()->fields()->get();

			$field[]= $req->form()->get()->toArray();
			foreach ($field as $values) {
				foreach ($values as $value) {
					array_push($ids, (int)$value['id']);
				}
			}
		}

		$ids = array_unique($ids);
		$fields = FormFields::whereIn('form_id', $ids)->get();
		$filter = $fields->toArray();
		$grouped = array();
		foreach ($filter as $arr) {
			if($arr['type'] == 'skill'){
				//var_dump(array_key_exists($arr['label'], $grouped));
				if(array_key_exists($arr['label'], $grouped)){
					array_push($grouped[$arr['label']], $arr);
				}else{
					$grouped[$arr['label']] = array();
					array_push($grouped[$arr['label']], $arr);
				}
			}
		}


		$selectedIds=array();
		foreach ($grouped as $skill => $group) {
			foreach ($group as $value) {
				if(array_key_exists($skill, $selectedIds)){
					$selectedIds[$skill][] = (int)$value['id'];
				}else{
					$selectedIds[$skill] = array();
					$selectedIds[$skill][] = (int)$value['id'];
				}      
			}
		}


		$optionArrayScore=array();
		$optionArrayYear=array();
		foreach ($selectedIds as $skill => $group) 
		{
			$submissions =  FormSubmissions::whereIn('field_id',$selectedIds[$skill])->get();
			foreach ($submissions as $f1) {
				$t=1;
				foreach(json_decode($f1->option) as $op) {
					if( $t == 1 || $t % 2 != 0)
					{
						if(array_key_exists($skill, $optionArrayScore)){
							$optionArrayScore[$skill][] = $op;
						}
						else
						{
							$optionArrayScore[$skill] = array();
							$optionArrayScore[$skill][] = $op;
						}  
					}
					else
					{
						if(array_key_exists($skill, $optionArrayYear)){
							$optionArrayYear[$skill][] = $op;
						}
						else
						{
							$optionArrayYear[$skill] = array();
							$optionArrayYear[$skill][] = $op;
						}
					}
					$t++;
				}
			}
		}

		$calculatedValue = array();
		$calculatedValueYear = array();
		$calculatedValueMscore = array();
		foreach ($optionArrayScore as $skill => $group) {
			$groupCount = count($optionArrayScore[$skill]);
			$value = 0;
			$score = 0;
			$year = 0;
			//$divider=10*$groupCount;
			for($i=0;$i < $groupCount;$i++){
				$score +=($optionArrayScore[$skill][$i]*2)*$optionArrayYear[$skill][$i];
				$year += $optionArrayYear[$skill][$i]; 
			}
			try{
				if (!$year) {

				}
				else
				{
					$calculatedValue[$skill] = $score;
					$calculatedValueYear[$skill] = $year;
					$calculatedValueMscore[$skill]=(($score/$year));
				}
			}catch(Exception $ex){
				$val = 0;
			}
		}
		
		$organization=Sentry::getUser()->hasAccess('organization');  

		$markskills = null;       
    
		return View::make('frontend/rank-main',compact('organization','calculatedValueMscore','request','seeker','writer','form','fields','id','grouped','calculatedValueYear','calculatedValue','markskills'));



        }


	
		return Response::make(View::make('error/404'), 404);
	}
	/**
	 * Redirect to the Individual Ranking page.
	 *
	 * @return View
	 */
	public function getRanksub($id=null)
	{
		$request = FormRequests::where('id' ,$id)->get();
		foreach ($request as $req) {


			$seeker[] = $req->seeker()->first();
			$writer[] = $req->writer()->first();

			$form[] = $req->form()->first();
			$tabs = $req->form()->first()->fields()->get();
			$field = $req->form()->get();

		}
		foreach ($field as $f) {
			$fields = $f->fields()->get();

		}
		$organization=Sentry::getUser()->hasAccess('organization');         

        //to get grouped score and year based on skill
		$ids = array();
		foreach ($request as $req) {


			$seeker[] = $req->seeker()->first();
			$writer[] = $req->writer()->first();

			$form[] = $req->form()->first();
			$tabs = $req->form()->first()->fields()->get();

			$fieldt[]= $req->form()->get()->toArray();
			foreach ($fieldt as $values) {
				foreach ($values as $value) {
					array_push($ids, (int)$value['id']);
				}
			}
		}
		$ids = array_unique($ids);
		$fields1 = FormFields::whereIn('form_id', $ids)->get();

		$filter = $fields1->toArray();
		$grouped = array();
		foreach ($filter as $arr) {
			if($arr['type'] == 'skill'){
				//var_dump(array_key_exists($arr['label'], $grouped));
				if(array_key_exists($arr['label'], $grouped)){
					array_push($grouped[$arr['label']], $arr);
				}else{
					$grouped[$arr['label']] = array();
					array_push($grouped[$arr['label']], $arr);
				}
			}
		}
		$selectedIds=array();
		foreach ($grouped as $skill => $group) {
			foreach ($group as $value) {
				if(array_key_exists($skill, $selectedIds)){
					$selectedIds[$skill][] = (int)$value['id'];
				}else{
					$selectedIds[$skill] = array();
					$selectedIds[$skill][] = (int)$value['id'];
				}      
			}
		}
		$optionArrayScore=array();
		$optionArrayYear=array();
		foreach ($selectedIds as $skill => $group) 
		{
			$submissions =  FormSubmissions::whereIn('field_id',$selectedIds[$skill])->get();
			foreach ($submissions as $f1) {
				$t=1;
				foreach(json_decode($f1->option) as $op) {
					if( $t == 1 || $t % 2 != 0)
					{
						if(array_key_exists($skill, $optionArrayScore)){
							$optionArrayScore[$skill][] = $op;
						}
						else
						{
							$optionArrayScore[$skill] = array();
							$optionArrayScore[$skill][] = $op;
						}  
					}
					else
					{
						if(array_key_exists($skill, $optionArrayYear)){
							$optionArrayYear[$skill][] = $op;
						}
						else
						{
							$optionArrayYear[$skill] = array();
							$optionArrayYear[$skill][] = $op;
						}
					}
					$t++;
				}
			}
		}
		$calculatedValue = array();
		$calculatedValueYear = array();
		$calculatedValueMscore = array();
		foreach ($optionArrayScore as $skill => $group) {
			$groupCount = count($optionArrayScore[$skill]);
			$value = 0;
			$score = 0;
			$year = 0;
			//$divider=10*$groupCount;
			for($i=0;$i < $groupCount;$i++){
				$score +=($optionArrayScore[$skill][$i]*2)*$optionArrayYear[$skill][$i];
				$year += $optionArrayYear[$skill][$i]; 
			}
			try{
				if (!$year) {

				}
				else
				{
					$calculatedValue[$skill] = $score;
					$calculatedValueYear[$skill] = $year;
					$calculatedValueMscore[$skill]=(($score/$year));
				}
			}catch(Exception $ex){
				$val = 0;
			}
		}
        //end grouping  

		return View::make('frontend/rank-ind',compact('organization','request','seeker','writer','form','tabs','fields','id','calculatedValueYear','calculatedValueMscore'));
	}
	/**
	 * Redirect to the Upload file page.
	 *
	 * @return View
	 */
	public function getUpload()
	{
		$organization=Sentry::getUser()->hasAccess('organization'); 
		return View::make('frontend/upload',compact('organization'));
	}
	/**
	 * Redirect to the upload Pdf page.
	 *
	 * @return View
	 */
	public function getPdf()
	{

		$organization=Sentry::getUser()->hasAccess('organization'); 
		return View::make('frontend/uploadpdf',compact('organization'));
	}
	/**
	 * Get Ocr uploaded Image Text.
	 *
	 * @return with Success with Text Extracted or Error
	 */
	public function postUpload()
	{

		// Build the input for our validation
		$input = array('image' => Input::file('image'));

	    // Within the ruleset, make sure we let the validator know that this
	    // file should be an image
		$rules = array(
			'image' => 'required|mimes:jpeg,png,pdf'
			);

	    // Now pass the input and rules into the validator
		$validator = Validator::make($input, $rules);

	    // Check to see if validation fails or passes
		if ($validator->fails())
		{
	        // Redirect with a helpful message to inform the user that 
	        // the provided file was not an adequate type
			return Redirect::back()->with('message', 'Error: The provided file was not an image');
		} else
		{

			$file = Input::file('image');
			$destinationPath = 'uploads/photos';
			$image = $file->getClientOriginalName();
			Input::file('image')->move($destinationPath, $image);

			require_once base_path().'/vendor/thiagoalessio/tesseract_ocr/TesseractOCR/TesseractOCR.php';

			$tesseract = new TesseractOCR(public_path().'/'.$destinationPath.'/'.$image);
			$tesseract->setTempDir(storage_path());
        	$tesseract->setLanguage('eng'); //same 3-letters code as tesseract training data packages
        	$ocr = $tesseract->recognize();

        	return Redirect::route('upload-form')->with('message', 'Success: File upload was successful')->with('ocr', $ocr);
        }

        return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Post the uploaded Pdf.
	 *
	 * @return with Success or Error
	 */
    public function postUploadPdf()
    {

		// Build the input for our validation
    	$input = array('pdf' => Input::file('pdf'));

	    // Within the ruleset, make sure we let the validator know that this
	    // file should be an image
    	$rules = array(
    		'pdf' => 'required|mimes:jpeg,png,pdf'
    		);

	    // Now pass the input and rules into the validator
    	$validator = Validator::make($input, $rules);

	    // Check to see if validation fails or passes
    	if ($validator->fails())
    	{
	        // Redirect with a helpful message to inform the user that 
	        // the provided file was not an adequate type
    		return Redirect::back()->with('message', 'Error: The provided file was not an image');
    	} else
    	{

    		$file = Input::file('pdf');
    		$destinationPath = 'uploads/pdf';
    		$image = $file->getClientOriginalName();
    		Input::file('pdf')->move($destinationPath, $image);
	    	// $ocrvalue=Input::get('txtareaUpload');
			//$form= Input::get('form_name');
    		$ocr = new Pdf;
    		$ocr->pdf = $image;
    		$ocr->user_id = Sentry::getUser()->id;
    		if($ocr->save())
    		{
    			return Redirect::back()->with('success', 'saved successfully');
    		}
    	}
    	return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Post the saved ocr Image text.
	 *
	 * @return with Success or Error
	 */
    public function saveOcr()
    {
    	$ocrvalue=Input::get('txtareaUpload');
    	$form= Input::get('form_name');

    	$ocr = new Ocr;
    	$ocr->ocr = $ocrvalue;
    	$ocr->form_name = $form;
    	$ocr->user_id = Sentry::getUser()->id;
    	if($ocr->save())
    	{
    		return Redirect::back()->with('success', 'saved successfully');
    	}

    	return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Delete a Pdf Uploaded from Database.
	 *
	 * @return back with Success or Error
	 */
    public function deletePdf($id=null)
    {

    	$pdf=Pdf::find($id);

    	if($pdf->delete())
    	{

    		return Redirect::back()->with('success', 'saved successfully');
    	}


    	return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Delete a Letter from Folder(change request letter folder id = zero).
	 *
	 * @return back with Success or Error
	 */
    public function deleteFromFolder($id=null)
    {
    	$r=FormRequests::find($id);
    	$r->folder_id=0;
    	if($r->save())
    	{
    		return Redirect::back()->with('success', 'saved successfully');
    	}

    	return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Delete a LinkedInRecommendation Letter from Folder(change recommendation letter folder id = zero).
	 *
	 * @return back with Success or Error
	 */
    public function deleteFromFolderRec($id=null)
    {
    	$r=LinkedinRecommendation::find($id);   
    	$r->folder_id=0;
    	if($r->save())
    	{
    		return Redirect::back()->with('success', 'saved successfully');
    	}

    	return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Delete a Ocr text saved in Ocr table.
	 *
	 * @return back with Success or Error
	 */
    public function deleteOcr($id=null)
    {
    	$ocr=Ocr::find($id);
    	if($ocr->delete())
    	{
    		return Redirect::back()->with('success', 'saved successfully');
    	}

    	return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Delete a LinkedInRecommendation Letter from table 'LinkedinRecommendation'.
	 *
	 * @return back with Success or Error
	 */
    public function deleteRecomend($id=null)
    {
    	$r=LinkedinRecommendation::find($id);
    	if($r->delete())
    	{
    		return Redirect::back()->with('success', 'saved successfully');
    	}

    	return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Delete a Request send from table 'FormRequests'.
	 *
	 * @return back with Success or Error
	 */
    public function deleteRequest($id=null)
    {
    	$r=FormRequests::find($id);
    	if($r->delete())
    	{
    		return Redirect::back()->with('success', 'saved successfully');
    	}

    	return Redirect::back()->with('error', 'An error occured');
    }
    /**
	 * Get the Report of a particular Submission using its id.
	 *
	 * @return View
	 */
    public function getReport($id = null){
    	$request = FormRequests::where('id' , $id )->where( 'submission_status' , 1 )->first();
    	$seeker = $request->seeker()->first();
    	$writer = $request->writer()->first();

    	$form = $request->form()->first();
    	$tabs = $request->form()->first()->fields()->get();
    	$fields = $request->form()->first()->fields()->get();

		//return View::make('pdf.submission', compact('request' , 'seeker' , 'writer' , 'form' , 'tabs' , 'fields') );
    	$organization=Sentry::getUser()->hasAccess('organization'); 
    	return  View::make('frontend/report', compact('request' , 'seeker' , 'writer' , 'form' , 'tabs' , 'fields','organization'));
    }


    // HELPER FUNCTIONS  //

	private function _generateId(){

		$id = str_random(10);
		if(!Forms::where('unique_id', $id )->get()->isEmpty())
			return $this->_generateId();
		return $id;
	}

}
