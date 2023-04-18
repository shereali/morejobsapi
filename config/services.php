<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '392227598149112',
        'client_secret' => 'a3287b48d96b97840dccd2d38131e6ea',
        'redirect' => env('FACEBOOK_URL'),
    ],

    'google' => [
        'client_id' => '398178910667-7cfu00p4na87bp9m7m073q9obeplhk96.apps.googleusercontent.com',
        'client_secret' => 'C8nwHJAaqoLi-MBa93SnqPrX',
        'redirect' => env('GOOGLE_URL'),
    ],

    'fbGoogleUserPass' => [
        'password' => 'faGoogle@pass'
    ]

];
