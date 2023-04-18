<?php

/**
 * @var \Laravel\Lumen\Routing\Router $router
 * Employee Section...
 */

$router->group(['middleware' => ['auth:api', 'hasCompany']], function ($router) {

    $router->group(['prefix' => 'job-posts'], function ($router) {
        $router->get('initiate', 'PostController@initiateList');
        $router->get('', 'PostController@index');
        $router->get('create', 'PostController@create');
        $router->post('', 'PostController@store');
        $router->get('{id}/repost', 'PostController@repost');
        $router->put('{id}/update-deadline', 'PostController@updateDeadline');
        $router->get('{id}/ready-to-process', 'PostController@readyToProcess');

        $router->group(['prefix' => '{id}/applicant-process'], function ($router) {
            $router->get('summary', 'ApplicantProcessController@summary');
            $router->get('preview', 'ApplicantProcessController@preview');
            $router->get('applicants', 'ApplicantProcessController@candidates');
        });
        $router->put('applicants/{id}/change-status', 'ApplicantProcessController@updateStatus');
    });

    $router->group(['prefix' => 'packages'], function ($router) {
        $router->get('types', 'PackageController@packageTypes');
        $router->get('initiate', 'PackageController@initiate');
        $router->post('subscribe', 'PackageController@subscribed');
        $router->post('subscribe-cancel', 'PackageController@cancel');
        $router->get('subscribed-list', 'PackageController@subscribedPackages');
    });

    $router->get('cv-banks', 'CVBankController@index');
    $router->get('cv-bank-list/{id}', 'CVBankController@cvBankList');
    $router->get('cv-bank-subscription-decrement', 'CVBankController@decrementCvSubscription');

    $router->group(['prefix' => 'account'], function ($router) {
        $router->get('edit-company', 'AccountController@editCompanyInitiate');
        $router->post('edit-company', 'AccountController@editCompany');
        $router->post('company/upload-logo', 'AccountController@uploadLogo');
    });
});



