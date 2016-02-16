<?php

Route::get('/', array('as' => 'home' , 'uses' => 'HomeController@getIndex'));

Route::get('pdf', function(){
	return View::make('pdf');
});

Route::get('ocr', array('as' => 'ocr' , 'uses' => 'HomeController@getOCR'));

Route::get('deadline', array('as' => 'deadline' , 'uses' => 'CronController@deadlineEmail'));


Route::get('form/{formId}', array('as' => 'writer-form', 'uses' => 'HomeController@getForm'));

Route::get('forms/{unique_id?}', array('as' => 'writer-forms', 'uses' => 'Controllers\Account\SubmissionController@getPublicForm'));

Route::get('getpublicform/{uid?}', array('as' => 'getpublicform', 'uses' => 'Controllers\Account\DashboardController@getToForm'));
Route::get('getpublicformloggedin/{uid?}', array('as' => 'getpublicformloggedin', 'uses' => 'Controllers\Account\DashboardController@getToFormloggedin'));

#get embed form
Route::get('embedform/{uid}', array('as' => 'embedform', 'uses' => 'HomeController@getEmbedForm'));

#get embed form
Route::get('skillcopysuccess/{uid}', array('as' => 'skillcopysuccess', 'uses' => 'HomeController@getSuccessCopySkill'));



Route::get('components/inputs', function()
{
	return View::make('frontend/forms/inputs');
});
Route::get('components/radioscheckboxes', function()
{
	return View::make('frontend/forms/radioscheckboxes');
});
Route::get('components/select', function()
{
	return View::make('frontend/forms/select');
});
Route::get('components/other', function()
{
	return View::make('frontend/forms/other');
});

Route::group(array('prefix' => 'ajax'), function()
{

	Route::post('contact', 'AjaxController@postContact');

	Route::post('seeker', 'AjaxController@postSeeker');
	Route::post('writer', 'AjaxController@postWriter');
	Route::post('fields', 'AjaxController@postFields');

	Route::post('getpreview', 'AjaxController@getPreview');

	Route::post('submit', 'AjaxController@postSubmit');
	Route::post('share', 'AjaxController@postShare');

	Route::post('shareOcr', 'AjaxController@postOcrShare');
	Route::post('sharePdf', 'AjaxController@postPdfShare');
	Route::post('shareRecommend', 'AjaxController@postRecommendShare');

	Route::post('shareFolder', 'AjaxController@postFolderShare');
	Route::post('saveFolder', 'AjaxController@postFolder');
	Route::post('addtofolder', 'AjaxController@postToFolder');
	
    #edit letter name
    Route::post('edit-letter-name', 'AjaxController@editLetterName');

    #edit folder name
    Route::post('edit-folder-name', 'AjaxController@editFolderName');

    #getSeeker Firstname and Lastname
    Route::post('get-seeker', 'AjaxController@getSeeker');
    
    #getSkillScore
    Route::post('getSkillScore', 'AjaxController@getSkillScore');

    #Done Skill Pasting
    Route::post('skill-paste-done', 'AjaxController@getDone');

});

Route::get('{requestId}/folder_submissions', array('as' => 'public_folder_submissions', 'uses' => 'HomeController@getPublicFolderSubmissions'));


Route::group(array('prefix' => 'admin'), function()
{

	# User Management
	Route::group(array('prefix' => 'users'), function()
	{
		Route::get('/', array('as' => 'users', 'uses' => 'Controllers\Admin\UsersController@getIndex'));
		Route::get('create', array('as' => 'create/user', 'uses' => 'Controllers\Admin\UsersController@getCreate'));
		Route::post('create', 'Controllers\Admin\UsersController@postCreate');
		Route::get('{userId}/edit', array('as' => 'update/user', 'uses' => 'Controllers\Admin\UsersController@getEdit'));
		Route::post('{userId}/edit', 'Controllers\Admin\UsersController@postEdit');
		Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'Controllers\Admin\UsersController@getDelete'));
		Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'Controllers\Admin\UsersController@getRestore'));
	});

	# User Management
	Route::group(array('prefix' => 'form-templates'), function()
	{
		Route::get('/', array('as' => 'form-templates', 'uses' => 'Controllers\Admin\FormTemplateController@getIndex'));
		Route::get('create', array('as' => 'create/form-template', 'uses' => 'Controllers\Admin\FormTemplateController@getCreate'));
		Route::post('create', 'Controllers\Admin\FormTemplateController@postCreate');
		Route::get('{formId}/edit', array('as' => 'update/form-template', 'uses' => 'Controllers\Admin\FormTemplateController@getEdit'));
		Route::post('{formId}/edit', 'Controllers\Admin\FormTemplateController@postEdit');
		Route::get('{formId}/delete', array('as' => 'delete/form-template', 'uses' => 'Controllers\Admin\FormTemplateController@getDelete'));
		Route::get('{formId}/restore', array('as' => 'restore/form-template', 'uses' => 'Controllers\Admin\FormTemplateController@getRestore'));
	});

	# Group Management
	Route::group(array('prefix' => 'groups'), function()
	{
		Route::get('/', array('as' => 'groups', 'uses' => 'Controllers\Admin\GroupsController@getIndex'));
		Route::get('create', array('as' => 'create/group', 'uses' => 'Controllers\Admin\GroupsController@getCreate'));
		Route::post('create', 'Controllers\Admin\GroupsController@postCreate');
		Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'Controllers\Admin\GroupsController@getEdit'));
		Route::post('{groupId}/edit', 'Controllers\Admin\GroupsController@postEdit');
		Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'Controllers\Admin\GroupsController@getDelete'));
		Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'Controllers\Admin\GroupsController@getRestore'));
	});

	# Dashboard-Admin
	Route::get('/', array('as' => 'admin', 'uses' => 'Controllers\Admin\DashboardController@getIndex'));

});

/*
|--------------------------------------------------------------------------
| Authentication and Authorization Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'auth'), function()
{

	# Login
	Route::get('signin', array('as' => 'signin', 'uses' => 'AuthController@getSignin'));
	Route::post('signin', 'AuthController@postSignin');

	# Register
	Route::get('signup', array('as' => 'signup', 'uses' => 'AuthController@getSignup'));
	Route::post('signup', 'AuthController@postSignup');

	# Account Activation
	Route::get('activate/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@getActivate'));

	# Forgot Password
	Route::get('forgot-password', array('as' => 'forgot-password', 'uses' => 'AuthController@getForgotPassword'));
	Route::post('forgot-password', 'AuthController@postForgotPassword');

	# Forgot Password Confirmation
	Route::get('forgot-password/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
	Route::post('forgot-password/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

	# Logout
	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

     # facebook
//    Route::get('facebook', array('as' => 'facebookLogin', 'uses' => 'AuthController@getFacebook'));
	Route::get('facebook-authentication', ['uses' => 'AuthController@getFacebookAuthentication', 'as' => 'facebook-login']);
	Route::get('twitter-authentication', ['uses' => 'AuthController@getTwitterAuthentication', 'as' => 'twitter-login']);
	Route::get('linkedin-authentication', ['uses' => 'AuthController@getLinkedinAuthentication', 'as' => 'linkedin-login']);
	Route::get('linkedin-dashboard-authentication', ['uses' => 'AuthController@getLinkedinDashboardAuth', 'as' => 'linkedin-dashboard-login']);

});

/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(array('prefix' => 'account'), function()
{
	#LinkedIn API Dashboard
	Route::get('dashboard', array('as' => 'dashboard' , 'uses' => 'Controllers\Account\DashboardController@getLinkedinDashboard'));
    
    #save LinkedIn Form with linkedin Skills
    Route::get('{company}/{letter_type}/postLinkedinForm', array('as' => 'postLinkedinForm', 'uses' => 'Controllers\Account\DashboardController@postLinkedinForm'));  

    
	# Account Dashboard
	Route::get('/', array('as' => 'account', 'uses' => 'Controllers\Account\DashboardController@getIndex'));

	# Profile
	Route::get('profile', array('as' => 'profile', 'uses' => 'Controllers\Account\ProfileController@getIndex'));
	Route::post('profile', 'Controllers\Account\ProfileController@postIndex');

	# Change Password
	Route::get('change-password', array('as' => 'change-password', 'uses' => 'Controllers\Account\ChangePasswordController@getIndex'));
	Route::post('change-password', 'Controllers\Account\ChangePasswordController@postIndex');

	# Change Email
	Route::get('change-email', array('as' => 'change-email', 'uses' => 'Controllers\Account\ChangeEmailController@getIndex'));
	Route::post('change-email', 'Controllers\Account\ChangeEmailController@postIndex');

    #upload Pdf
	Route::get('uploadpdf', array('as' => 'upload-form-pdf', 'uses' => 'Controllers\Account\DashboardController@getPdf'));
	Route::post('upload/pdf' , array('as' => 'upload/pdf', 'uses' => 'Controllers\Account\DashboardController@postUploadPdf' ));
	Route::get('{pdfId}/pdfdelete', array('as' => 'pdfdelete', 'uses' => 'Controllers\Account\DashboardController@deletePdf' ));

	

    #folderDelete
	Route::get('{rqId}/deletefromfolder', array('as' => 'deletefromfolder', 'uses' => 'Controllers\Account\DashboardController@deleteFromFolder' )); 
	Route::get('{recId}/deletefromfolderrec', array('as' => 'deletefromfolderrec', 'uses' => 'Controllers\Account\DashboardController@deleteFromFolderRec' ));

    #upload OCR
	Route::get('upload', array('as' => 'upload-form', 'uses' => 'Controllers\Account\DashboardController@getUpload'));
	Route::post('upload/ocr' , array('as' => 'upload/ocr', 'uses' => 'Controllers\Account\DashboardController@postUpload' ));
	Route::post('save/ocr' , array('as' => 'save/ocr', 'uses' => 'Controllers\Account\DashboardController@saveOcr' ));
	Route::get('{ocrId}/ocrdelete', array('as' => 'ocrdelete', 'uses' => 'Controllers\Account\DashboardController@deleteOcr' ));

    #LinkedRecommendations
	Route::get('{recomendId}/recommenddelete', array('as' => 'recommenddelete', 'uses' => 'Controllers\Account\DashboardController@deleteRecomend' ));

    #DeleteRequest
	Route::get('{requestId}/requestdelete', array('as' => 'requestdelete', 'uses' => 'Controllers\Account\DashboardController@deleteRequest' ));

    #linked-in
	Route::get('linkedin', array('as' => 'linkedin', 'uses' => 'Controllers\Account\LinkedInController@getIndex'));
	Route::post('linkedin' , array('as' => 'linkedin/save', 'uses' => 'Controllers\Account\LinkedInController@postIndex' ));

	# User Management
	Route::group(array('prefix' => 'form'), function()
	{
		//Forms
		Route::get('/', array('as' => 'forms', 'uses' => 'Controllers\Account\FormController@getIndex'));

		Route::get('{formId}/delete', array('as' => 'delete/form', 'uses' => 'Controllers\Account\FormController@getDelete'));
		Route::get('{formId}/archive', array('as' => 'archive/form', 'uses' => 'Controllers\Account\FormController@getArchive'));
		Route::get('{formId}/restore', array('as' => 'restore/form', 'uses' => 'Controllers\Account\FormController@getRestore'));
		Route::get('{formId}/activate', array('as' => 'activate/form', 'uses' => 'Controllers\Account\FormController@getActivate'));

		Route::get('new', array( 'as' => 'new/form' ,'uses' =>'Controllers\Account\FormController@getNew')); 
		Route::get('new-posting', array( 'as' => 'new/posting' ,'uses' =>'Controllers\Account\FormController@getNewPosting')); 

		Route::get('{formId}/edit', array('as' => 'edit/form', 'uses' => 'Controllers\Account\FormController@getEdit'));
		Route::get('{formId}/editposting', array('as' => 'edit/posting', 'uses' => 'Controllers\Account\FormController@getPostingEdit'));
        
        //posting form skills	
		Route::get('{formId}/postskills', array('as' => 'postskills', 'uses' => 'Controllers\Account\FormController@postSkills'));
        //publish
        Route::get('{formId}/publish',array('as'=>'publish','uses' => 'Controllers\Account\FormController@publishForm'));
        //posted skills edit 
        Route::get('{formId}/edit-posted-skills', array('as' => 'edit-posted-skills', 'uses' => 'Controllers\Account\FormController@getPostedEdit'));
          
		// Requests
		Route::get('{formId}/send', array('as' => 'send/form', 'uses' => 'Controllers\Account\FormController@getSend'));
		Route::get('{requestId}/resend', array('as' => 'resend', 'uses' => 'Controllers\Account\FormController@getResend'));
		Route::post('{formId}/send', 'Controllers\Account\FormController@postSend');
		Route::get('{formId}/requests', array('as' => 'requests/form', 'uses' => 'Controllers\Account\RequestController@getRequests'));

		Route::get('{formId}/submissions', array('as' => 'submissions/form', 'uses' => 'Controllers\Account\SubmissionController@getSubmissions'));
	});

Route::group( array( 'prefix' => 'requests') , function()
{
	Route::get('/', array('as' => 'all/requests', 'uses' => 'Controllers\Account\RequestController@getAllRequests'));

});

Route::group( array( 'prefix' => 'submissions') , function()
{

	Route::get('/', array('as' => 'all/submissions', 'uses' => 'Controllers\Account\SubmissionController@getAllSubmissions'));

	Route::get('{submissionId}/view', array('as' => 'view/submission', 'uses' => 'Controllers\Account\SubmissionController@getView'));

	Route::get('{requestId}/submissiondelete', array('as' => 'submissiondelete', 'uses' => 'Controllers\Account\SubmissionController@deleteSubmission'));
    //update submission view
    Route::get('{submissionId}/submission-update-view', array('as' => 'submission-update-view', 'uses' => 'Controllers\Account\SubmissionController@getSubUpdateView'));    
    //ask for update add in submission 	
	Route::post('{requestId}/submissionupdate', array('as' => 'submissionupdate', 'uses' => 'Controllers\Account\SubmissionController@updateSubmission'));
    //ask for update edit in submission 	
	Route::post('{requestId}/submissionupdate-edit', array('as' => 'submissionupdate-edit', 'uses' => 'Controllers\Account\SubmissionController@updateSubmissionEdit'));
    //ask for update delete in submission 	
	Route::get('submissionupdate-del/{requestId}/{formId}', array('as' => 'submissionupdate-del', 'uses' => 'Controllers\Account\SubmissionController@updateSubmissionDel'));
    //ask for updation after deleting skill 	
	Route::get('{requestId}/submission-del-update', array('as' => 'submission-del-update', 'uses' => 'Controllers\Account\SubmissionController@updateDelSubmission'));
});

Route::get('submissionsfolder', array('as' => 'submissionsfolder', 'uses' => 'Controllers\Account\FolderController@getAllFolderSubmissions'));

Route::get('{requestId}/folder_submissions', array('as' => 'folder_submissions', 'uses' => 'Controllers\Account\FolderController@getFolderSubmissions'));

Route::get('{requestId}/folder-ranking', array('as' => 'folder-ranking', 'uses' => 'Controllers\Account\FolderController@getFolderRanking'));
	// PDF generator
Route::group( array( 'prefix' => 'download-pdf') , function()
{
	Route::get('{requestId}/submission', array('as' => 'pdf/submission', 'uses' => 'Controllers\Account\PdfController@getSubmission'));
	Route::get('{requestId}/recommendation', array('as' => 'pdf/recommendation', 'uses' => 'Controllers\Account\PdfController@getRecommendation'));
	Route::get('{ocrId}/submissions', array('as' => 'pdf/submissions', 'uses' => 'Controllers\Account\PdfController@getSubmissions'));


});

   	# ajax
Route::group(array('prefix' => 'ajax'), function()
{

	Route::post('form', 'Controllers\Account\AjaxController@postNewForm');
	Route::post('formDelete', 'Controllers\Account\AjaxController@DeleteFormId');
	Route::post('name', 'Controllers\Account\AjaxController@postName');
	Route::post('saveForm', 'Controllers\Account\AjaxController@postForm');

	Route::post('share', 'Controllers\Account\AjaxController@postShare');
});

Route::get('timeline',array('as' => 'timeline', 'uses'=> 'Controllers\Account\DashboardController@getTimeline'));

Route::get('mainranking',array('as' => 'mainranking', 'uses'=> 'Controllers\Account\DashboardController@getMainRank'));

Route::get('{requestId}/skillranking',array('as' => 'skillranking', 'uses'=> 'Controllers\Account\DashboardController@getSkillMainRank'));

Route::get('{formId}/rank',array('as' => 'rank', 'uses'=> 'Controllers\Account\DashboardController@getRank'));

Route::get('{requestId}/ranksub',array('as' => 'ranksub', 'uses'=> 'Controllers\Account\DashboardController@getRanksub'));

Route::get('{requestId}/report', array('as' => 'report', 'uses' => 'Controllers\Account\DashboardController@getReport'));
});


Route::get('facebook', array( 'as' => 'facebook', function(){
	$service = SentrySocial::make('facebook', 'http://soarmorrow.com/works/infographics/public/auth/facebook');
	return Redirect::to((string) $service->getAuthorizationUri());
}));



