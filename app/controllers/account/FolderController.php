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
use FormFields;
use FormSubmissions;
use Response;

class FolderController extends AuthorizedController {	

	public function getAllFolderSubmissions(){

		$requests = Submission_folder::where('user_id' , Sentry::getUser()->id )->get();
		// Show the page`
		$ocr = Ocr::get(); 
		$organization=Sentry::getUser()->hasAccess('organization');
		$recommendations = LinkedinRecommendation::where('user_id' , Sentry::getUser()->id )->get();
		return View::make('frontend/forms/foldersubmissions' , compact('requests','ocr','organization' , 'recommendations'));
	}

	public function getFolderSubmissions($id = null){

		$requests = FormRequests::with('writer')->where('folder_id' , $id )->where( 'submission_status' , 1 )->get();
		
		$folder = Submission_folder::find($id);
		$organization=Sentry::getUser()->hasAccess('organization');
		$recommendations = LinkedinRecommendation::where('user_id' , Sentry::getUser()->id )->where('folder_id',$id)->get();
		// Show the page
		return View::make('frontend/forms/folder_submissions' , compact('requests','folder','organization', 'recommendations'));
	}

	public function getFolderRanking($id = null){

		$request = FormRequests::where('folder_id' , $id )->where( 'submission_status' , 1 )->get();
		
		//var_dump($request);exit();
		if($request->isEmpty())
		{

		 return Response::make(View::make('error/404'), 404);exit();
		}

		$folder = Submission_folder::find($id);
		$organization=Sentry::getUser()->hasAccess('organization');
		$recommendations = LinkedinRecommendation::where('user_id' , Sentry::getUser()->id )->where('folder_id',$id)->get();

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

		// filtering and grouping based on label
		/*
		`grouped` is an associative array contain field array and label as key

		$grouped = array(
			'PHP' => array(
				array(elements that has label php),
				array(elements that has label php),
				array(elements that has label php),
			),
			'SQL' => array(
				array(elements that has label sql),
				array(elements that has label sql),
				array(elements that has label sql),
			)
		);
		*/
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
foreach ($optionArrayScore as $skill => $group) {
	$groupCount = count($optionArrayScore[$skill]);
	$value = 0;
	$nominator = 0;
	$denominator = 0;
	for($i=0;$i < $groupCount;$i++){
		$nominator += ($optionArrayScore[$skill][$i]*2*$optionArrayYear[$skill][$i]);
		$denominator += $optionArrayYear[$skill][$i]; 
	}
	try{

		$val =  ($nominator/$denominator);
		$calculatedValue[$skill] = $val;
		$calculatedValueYear[$skill] = $denominator;

	}catch(Exception $ex){
		$val = 0;
	}

}
//var_dump($calculatedValue);exit();


      // var_dump($submissions);exit();
		// Show the page
return View::make('frontend/rank-folder',compact('organization','request','seeker','writer','grouped','form','calculatedValueYear','fields','id','calculatedValue'));
}

public function getFolderView($id = null){

	$request = FormRequests::where('id' , $id )->where( 'submission_status' , 1 )->first();
	$seeker = $request->seeker()->first()->toArray();
	$writer = $request->writer()->first()->toArray();

	$form = $request->form()->first();
	$tabs = $request->form()->first()->fields()->get();
	$fields = $request->form()->first()->fields()->get();


	$organization=Sentry::getUser()->hasAccess('organization');
		// Show the page
	return View::make('frontend/forms/foldersubmission' , compact('request' , 'seeker' , 'writer' , 'form' , 'tabs' , 'fields','organization'));
}
}