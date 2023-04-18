<?php

/** @var \Laravel\Lumen\Routing\Router $router */

//$router->get('/', function () use ($router) {
//    return $router->app->version();
//});


/**
 *  Third-party app(google, facebook) login...
 */

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

$router->get('login-credentials-details', function () {
    return Hash::make('morejobs123');
});
$router->get('third-party-login', 'Auth\LoginController@redirect');
$router->get('{provider}/callback', 'Auth\LoginController@callback');
$router->post('login', 'Auth\LoginController@login');

$router->post('system_login', 'Auth\LoginController@systemLogin');

$router->get('change-lang/{locale}', function ($locale) {
    app()->setLocale($locale);
    return Config::get('app.locale');
    // App::setLocale('bn');
});

$router->get('initiate/employee-register', 'Auth\RegisterController@initiateEmployeeRegister');
$router->post('employee-register', 'Auth\RegisterController@employeeRegister');

$router->get('initiate/employer-register', 'Auth\EmployerRegisterController@initiateEmployerRegister');
$router->post('employer-register', 'Auth\EmployerRegisterController@employerRegister');

$router->post('forgot-password', 'Auth\RegisterController@sendResetPasswordCode');
$router->post('verify-reset-password-code', 'Auth\RegisterController@verifyResetPasswordCode');
$router->post('reset-password', 'Auth\RegisterController@resetPassword');

$router->group(['middleware' => ['auth:api']], function ($router) {
    $router->get('user-info', 'UserController@userInfo');
    $router->get('auth-user-info', 'UserController@authUser');

    $router->group(['prefix' => 'account'], function ($router) {
        $router->get('send-verification-code', 'Auth\LoginController@sendOTP');
        $router->post('verify', 'Auth\LoginController@verifyAccount');
        $router->post('change-userid', 'UserController@updateUserId');

        $router->post('change-password', 'UserController@updatePassword');
        $router->get('logout', 'Auth\LoginController@logout');

        $router->post('image/upload', 'UserController@uploadAvatar');
        $router->delete('image/destroy', 'UserController@destroyAvatar');

        $router->get('delete', 'Auth\LoginController@deleteAccount');
    });

    //Auth tokens
    $router->group(['prefix' => 'oauth-access-tokens'], function ($router) {
        $router->get('sign-out-from-all-devices', 'Auth\OauthTokenControl@signOutFormAllDevices');
        $router->get('', 'Auth\OauthTokenControl@index');
        $router->delete('{id}', 'Auth\OauthTokenControl@destroy');

        $router->post('refresh', 'Auth\LoginController@refreshToken');
    });

    $router->get('job-list/{id}/check-applied', 'Home\HomeController@checkApplied');
    $router->put('job-list/{id}/apply-online', 'Home\HomeController@submitJobApplication');

    $router->get('company-list/{id}/check-followed', 'Home\EmployerController@checkFollowed');
    $router->get('company-list/{id}/followed-unfollow', 'Home\EmployerController@followUnfollowCompany');
});

//Admission
$router->get('admission', ['as' => 'admission', 'uses' => 'Home\BlogController@index']);
$router->get('admission/{id}', ['as' => 'admissionDetails', 'uses' => 'Home\BlogController@show']);

//Scholarship
$router->get('scholarship', ['as' => 'scholarship', 'uses' => 'Home\BlogController@index']);
$router->get('scholarship/{id}', ['as' => 'scholarshipDetails', 'uses' => 'Home\BlogController@show']);

//Events
$router->get('events', ['as' => 'events', 'uses' => 'Home\BlogController@index']);
$router->get('events/{id}', ['as' => 'eventsDetails', 'uses' => 'Home\BlogController@show']);


$router->get('contact-us', 'Home\ContactUsController@index');

$router->get('employer-services', 'Home\EmployerController@services');
$router->get('company-list/{id}/details', 'Home\EmployerController@show');
$router->get('company-list/{id}/available-jobs', 'Home\EmployerController@availableJobs');

//Course Section...
//$router->group('', function ($router) {
//
//});

$router->get('/pages/{fileName}', 'Home\HomeController@example');


$router->get('', 'Home\HomeController@home');
$router->get('job-lists', 'Home\HomeController@jobList');
$router->get('job-list/{id}/details', 'Home\HomeController@postDetails');
$router->get('job-list/{id}/apply-online', 'Home\HomeController@applyOnline');
$router->get('category-wise-job-summary', 'Home\HomeController@categoryJobSummary');

//Articles
$router->get('articles', ['as' => 'articles', 'uses' => 'Home\BlogController@index']);
$router->get('articles/{id}', ['as' => 'articlesDetails', 'uses' => 'Home\BlogController@show']);

$router->get('company-list', 'Home\EmployerController@index');

$router->get('training-courses', 'Home\TrainingCoursesController@index');
$router->get('training-courses/{id}', 'Home\TrainingCoursesController@show');
$router->get('training-course-list', 'Home\TrainingCoursesController@courseList');

$router->group(['middleware' => ['localization'], 'prefix' => '{lang}'], function ($router) {
    $router->get('', 'Home\HomeController@home');
    $router->get('job-lists', 'Home\HomeController@jobList');
    $router->get('job-list/{id}/details', 'Home\HomeController@postDetails');
    $router->get('job-list/{id}/apply-online', 'Home\HomeController@applyOnline');
    $router->get('category-wise-job-summary', 'Home\HomeController@categoryJobSummary');

    $router->get('company-list', 'Home\EmployerController@index');

    $router->get('training-courses', 'Home\TrainingCoursesController@index');
    $router->get('training-courses/{id}', 'Home\TrainingCoursesController@show');


    //Articles
    $router->get('articles', ['as' => 'articles', 'uses' => 'Home\BlogController@index']);
    $router->get('articles/{id}', ['as' => 'articlesDetails', 'uses' => 'Home\BlogController@show']);
});
