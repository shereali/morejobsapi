<?php

/**
 * @var \Laravel\Lumen\Routing\Router $router
 * Employee Section...
 */

$router->group(['middleware' => ['auth:api']], function ($router) {
    resource('companies', 'CompanyController');
    $router->get('companies-list-summary', 'CompanyController@initiateListSummary');

    resource('subscriptions', 'SubscriptionController');
    $router->get('subscription-list-summary', 'SubscriptionController@initiateListSummary');

    resource('posts', 'PostController');
    $router->get('posts-list-summary', 'PostController@initiateListSummary');

    resource('users', 'UserController');
    resource('trainers', 'TrainerController');

    $router->group(['prefix' => 'trainings'], function ($router) {
        $router->get('', 'TrainingController@index');
        $router->get('create', 'TrainingController@create');
        $router->post('', 'TrainingController@store');
        $router->delete('{id}', 'TrainingController@destroy');
    });

    $router->group(['prefix' => 'employees'], function ($router) {
        $router->get('', 'EmployeeController@index');
        $router->get('{id}', 'EmployeeController@show');
    });


    $router->group(['prefix' => 'settings', 'namespace' => 'Settings'], function ($router) {
        $router->get('areas-initiate-filters', 'AreaController@initiateFilters');
        resource('areas', 'AreaController');

        $router->get('categories-initiate-filters', 'CategoryController@initiateFilters');
        $router->group(['prefix' => 'categories'], function ($router) {
            resource('', 'CategoryController');
            $router->post('sort', 'CategoryController@sort');
        });

        $router->get('degrees-initiate-filters', 'DegreeController@initiateFilters');
        $router->group(['prefix' => 'degrees'], function ($router) {
            resource('', 'DegreeController');
            $router->post('sort', 'DegreeController@sort');
        });

        $router->get('industry-types-initiate-filters', 'IndustryTypeController@initiateFilters');
        $router->group(['prefix' => 'industry-types'], function ($router) {
            resource('', 'IndustryTypeController');
        });

        resource('skills', 'SkillController');
        resource('institutes', 'InstituteController');
    });

    resource('blogs', 'BlogController');

    resource('ads', 'AdsController');
});



