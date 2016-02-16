<?php namespace Controllers\Account;

use OAuth;
use AuthorizedController;
use View;
use Input;
use User;
use Redirect;
use Session;
use LinkedinRecommendation;
use Sentry;

class LinkedInController extends AuthorizedController {

    /**
     * Redirect to the profile page.
     *
     * @return Redirect
     */

    protected $userModel;

    public function __construct(User $user) {
        $this->userModel = $user;
        parent::__construct();
    }

    public function getIndex()
    {
        $code = Input::get('code', NULL);

        $linkedinService = OAuth::consumer('Linkedin');

        if (!empty($code)) {

            // This was a callback request from linkedin, get the token
            $token = $linkedinService->requestAccessToken($code);

            $get = Session::get('get');
            Session::forget('get');
            

            if(!empty($get)){

                foreach ( json_decode( Session::get('recommendations') , true ) as $r) {
                    if($get['id'] == $r['id']){
                        $recommender_id = $r['recommender']['id']; 
                        $recommendation = $r;
                    }
                }

                Session::forget('recommendations');

                if(!empty( $recommender_id )){
                    // Send a request with it. Please note that XML is the default format.
                    $result = json_decode($linkedinService->request('/people/id='.$recommender_id.'?format=json'), true);

                    if(!$r = LinkedinRecommendation::where('recommendation_id' , $recommendation['id'])->first())
                        $r = new LinkedinRecommendation;
                    $r->recommendation_id = $recommendation['id'];
                    $r->user_id = Sentry::getUser()->id;
                    $r->recommended_by = $recommendation['recommender']['firstName']. ' '.$recommendation['recommender']['lastName'];
                    $r->by_headline = $result['headline'];

                    $user = Session::get('user');
                    $user = json_decode($user , true);
                    if($user['_total'] > 0){
                        $r->user_position = $user['values'][0]['title'];
                        $r->user_company = $user['values'][0]['company']['name'];

                        Session::forget('user');
                    }
                    $r->recommend_text = $recommendation['recommendationText'];
                    $r->save();
                   
                    return Redirect::route('linkedin')->with('success' , 'Recommendation added');

                }


            }
            else{

                // Send a request with it. Please note that XML is the default format.
                $result = json_decode($linkedinService->request('/people/~:(recommendations-received,three-current-positions)?format=json'), true);

                $recommendations = $result['recommendationsReceived'];
                $user = $result['threeCurrentPositions'];

                Session::put('recommendations' , json_encode($recommendations['values']) );
                Session::put('user' , json_encode($user) );
                 $organization=Sentry::getUser()->hasAccess('organization'); 
                return View::make('frontend/forms/linkedin' , compact('recommendations','organization'));
            }
        }// if not ask for permission first
        else {
            // get linkedinService authorization
            $url = $linkedinService->getAuthorizationUri(array('state' => 'DCEEFWF45453sdffef424'));
            // return to linkedin login url
            return Redirect::away((string) $url);
        }
        
    }


    public function postIndex(){
    

        Session::put( 'get' , Input::except('code'));

        $linkedinService = OAuth::consumer('Linkedin');

        // get linkedinService authorization
        $url = $linkedinService->getAuthorizationUri(array('state' => 'DCEEFWF45453sdffef424'));
        // return to linkedin login url
        return Redirect::away((string) $url);

    }


}
