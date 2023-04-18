<?php

/**
 * @var \Laravel\Lumen\Routing\Router $router
 * Employee Section...
 */

$router->get('download-doc', 'ResumeController@resumeDownloadDoc');

$router->group(['middleware' => ['auth:api']], function ($router) {
    $router->get('employee-summary', 'SummaryController@summary');

    $router->group(['prefix' => 'resume'], function ($router) {
        $router->get('file/show', 'ResumeController@resumeFileShow');
        $router->post('upload', 'ResumeController@uploadResume');
        $router->delete('delete', 'ResumeController@destroyResume');
        $router->get('download', 'ResumeController@resumeDownload');

        $router->get('{id}/show', 'ResumeController@show');
        $router->get('edit', 'ResumeController@edit');
        $router->post('update', 'ResumeController@update');

        $router->delete('languages/{id}', 'ResumeController@deleteLanguage');
        $router->delete('references/{id}', 'ResumeController@deleteReference');
        $router->delete('educations/{id}', 'ResumeController@deleteEducation');
        $router->delete('trainings/{id}', 'ResumeController@deleteTraining');
        $router->delete('certificates/{id}', 'ResumeController@deleteCertificate');

        $router->post('sent-email', 'ResumeController@sendEmail');
    });

    $router->group(['prefix' => 'my-activity'], function ($router) {
        $router->group(['prefix' => 'online-applications', 'namespace' => 'MyActivity'], function ($router) {
            $router->get('', 'ApplicationController@index');
        });

        $router->group(['prefix' => 'favorite-companies', 'namespace' => 'MyActivity'], function ($router) {
            $router->get('', 'FollowCompanyController@index');
            $router->get('{companyId}/unfollow-company', 'FollowCompanyController@unfollowCompany');
        });

        $router->group(['prefix' => 'unfollowed-companies', 'namespace' => 'MyActivity'], function ($router) {
            $router->get('initiateFilters', 'FollowCompanyController@initiateFilterUnfollowedCompanyList');
            $router->get('', 'FollowCompanyController@companyList');
            $router->get('{companyId}/show', 'FollowCompanyController@companyShow');
            $router->get('{companyId}/follow-company', 'FollowCompanyController@followCompany');
        });

        $router->group(['prefix' => 'favorite-posts', 'namespace' => 'MyActivity'], function ($router) {
            $router->get('', 'FavoritePostController@index');
            $router->post('delete', 'FavoritePostController@destroy');
        });
    });

    $router->group(['prefix' => 'company-activity', 'namespace' => 'CompanyActivity'], function ($router) {
        $router->get('resume-views', 'CompanyActivityController@index');
        $router->get('cv-summary', 'CompanyActivityController@cvSummary');
    });

    $router->get('shortlist-job/{id}', 'MyActivity\FavoritePostController@jobShortlist');
});

