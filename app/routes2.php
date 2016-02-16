<?php

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@getIndex'));


Route::get('form/{formId}', array('as' => 'writer-form', 'uses' => 'HomeController@getForm'));

Route::get('forms/{unique_id}', array('as' => 'writer-forms', 'uses' => 'HomeController@getPublicForm'));



Route::get('components/inputs', function() {
    return View::make('frontend/forms/inputs');
});
Route::get('components/radioscheckboxes', function() {
    return View::make('frontend/forms/radioscheckboxes');
});
Route::get('components/select', function() {
    return View::make('frontend/forms/select');
});

Route::group(array('prefix' => 'ajax'), function() {

    Route::post('contact', 'AjaxController@postContact');

    Route::post('seeker', 'AjaxController@postSeeker');
    Route::post('writer', 'AjaxController@postWriter');
    Route::post('fields', 'AjaxController@postFields');

    Route::post('submit', 'AjaxController@postSubmit');
    Route::post('share', 'AjaxController@postShare');
});

Route::group(array('prefix' => 'admin'), function() {

    # User Management
    Route::group(array('prefix' => 'users'), function() {
        Route::get('/', array('as' => 'users', 'uses' => 'Controllers\Admin\UsersController@getIndex'));
        Route::get('create', array('as' => 'create/user', 'uses' => 'Controllers\Admin\UsersController@getCreate'));
        Route::post('create', 'Controllers\Admin\UsersController@postCreate');
        Route::get('{userId}/edit', array('as' => 'update/user', 'uses' => 'Controllers\Admin\UsersController@getEdit'));
        Route::post('{userId}/edit', 'Controllers\Admin\UsersController@postEdit');
        Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'Controllers\Admin\UsersController@getDelete'));
        Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'Controllers\Admin\UsersController@getRestore'));
    });

    # User Management
    Route::group(array('prefix' => 'form-templates'), function() {
        Route::get('/', array('as' => 'form-templates', 'uses' => 'Controllers\Admin\FormTemplateController@getIndex'));
        Route::get('create', array('as' => 'create/form-template', 'uses' => 'Controllers\Admin\FormTemplateController@getCreate'));
        Route::post('create', 'Controllers\Admin\FormTemplateController@postCreate');
        Route::get('{formId}/edit', array('as' => 'update/form-template', 'uses' => 'Controllers\Admin\FormTemplateController@getEdit'));
        Route::post('{formId}/edit', 'Controllers\Admin\FormTemplateController@postEdit');
        Route::get('{formId}/delete', array('as' => 'delete/form-template', 'uses' => 'Controllers\Admin\FormTemplateController@getDelete'));
        Route::get('{formId}/restore', array('as' => 'restore/form-template', 'uses' => 'Controllers\Admin\FormTemplateController@getRestore'));
    });

    # Group Management
    Route::group(array('prefix' => 'groups'), function() {
        Route::get('/', array('as' => 'groups', 'uses' => 'Controllers\Admin\GroupsController@getIndex'));
        Route::get('create', array('as' => 'create/group', 'uses' => 'Controllers\Admin\GroupsController@getCreate'));
        Route::post('create', 'Controllers\Admin\GroupsController@postCreate');
        Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'Controllers\Admin\GroupsController@getEdit'));
        Route::post('{groupId}/edit', 'Controllers\Admin\GroupsController@postEdit');
        Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'Controllers\Admin\GroupsController@getDelete'));
        Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'Controllers\Admin\GroupsController@getRestore'));
    });

    # Dashboard
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

Route::group(array('prefix' => 'auth'), function() {

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
});

/*
  |--------------------------------------------------------------------------
  | Account Routes
  |--------------------------------------------------------------------------
  |
  |
  |
 */

Route::group(array('prefix' => 'account'), function() {

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

    # User Management
    Route::group(array('prefix' => 'form'), function() {
        //Forms
        Route::get('/', array('as' => 'forms', 'uses' => 'Controllers\Account\FormController@getIndex'));

        Route::get('{formId}/delete', array('as' => 'delete/form', 'uses' => 'Controllers\Account\FormController@getDelete'));
        Route::get('{formId}/archive', array('as' => 'archive/form', 'uses' => 'Controllers\Account\FormController@getArchive'));
        Route::get('{formId}/restore', array('as' => 'restore/form', 'uses' => 'Controllers\Account\FormController@getRestore'));
        Route::get('{formId}/activate', array('as' => 'activate/form', 'uses' => 'Controllers\Account\FormController@getActivate'));

        Route::get('new', array('as' => 'new/form', 'uses' => 'Controllers\Account\FormController@getNew'));

        Route::get('{formId}/edit', array('as' => 'edit/form', 'uses' => 'Controllers\Account\FormController@getEdit'));


        // Requests
        Route::get('{formId}/send', array('as' => 'send/form', 'uses' => 'Controllers\Account\FormController@getSend'));
        Route::post('{formId}/send', 'Controllers\Account\FormController@postSend');
        Route::get('{formId}/requests', array('as' => 'requests/form', 'uses' => 'Controllers\Account\RequestController@getRequests'));

        Route::get('{formId}/submissions', array('as' => 'submissions/form', 'uses' => 'Controllers\Account\SubmissionController@getSubmissions'));
    });

    Route::group(array('prefix' => 'requests'), function() {
        Route::get('/', array('as' => 'all/requests', 'uses' => 'Controllers\Account\RequestController@getAllRequests'));
    });

    Route::group(array('prefix' => 'submissions'), function() {

        Route::get('/', array('as' => 'all/submissions', 'uses' => 'Controllers\Account\SubmissionController@getAllSubmissions'));

        Route::get('{submissionId}/view', array('as' => 'view/submission', 'uses' => 'Controllers\Account\SubmissionController@getView'));
    });

    // PDF generator
    Route::group(array('prefix' => 'download-pdf'), function() {
        Route::get('{requestId}/submission', array('as' => 'pdf/submission', 'uses' => 'Controllers\Account\PdfController@getSubmission'));
    });

    # ajax
    Route::group(array('prefix' => 'ajax'), function() {

        Route::post('form', 'Controllers\Account\AjaxController@postNewForm');
        Route::post('formDelete', 'Controllers\Account\AjaxController@DeleteFormId');
        Route::post('name', 'Controllers\Account\AjaxController@postName');
        Route::post('saveForm', 'Controllers\Account\AjaxController@postForm');

        Route::post('share', 'Controllers\Account\AjaxController@postShare');
    });

    Route::get('timeline', array('as' => 'timeline', 'uses' => 'Controllers\Account\DashboardController@getTimeline'));

    Route::get('{requestId}/report', array('as' => 'report', 'uses' => 'Controllers\Account\DashboardController@getReport'));
});


Route::get('facebook', array('as' => 'facebook', function() {
$service = SentrySocial::make('facebook', 'http://soarmorrow.com/works/infographics/public/auth/facebook');
return Redirect::to((string) $service->getAuthorizationUri());
}));



