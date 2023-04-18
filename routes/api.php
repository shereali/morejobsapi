<?php

/**
 * @var \Laravel\Lumen\Routing\Router $router
 * Admin Section...
 */


$router->group(['middleware' => ['auth:api']], function ($router) {
    $router->group(['prefix' => '', 'namespace' => 'Employee'], function ($router) {
        resource('my-posts', 'PostController');
    });


    $router->group(['prefix' => '', 'namespace' => 'Admin'], function ($router) {
        resource('users', 'UserController');

        resource('companies', 'CompanyController');
        resource('posts', 'PostController');


        $router->group(['prefix' => 'settings', 'namespace' => 'Settings'], function ($router) {
            resource('areas', 'AreaController');

            $router->group(['prefix' => 'categories'], function ($router) {
                resource('', 'CategoryController');
                $router->post('sort', 'CategoryController@sort');
            });

            $router->group(['prefix' => 'degrees'], function ($router) {
                resource('', 'DegreeController');
                $router->post('sort', 'DegreeController@sort');
            });

            resource('skills', 'SkillController');
            resource('institutes', 'InstituteController');
        });
    });


});

