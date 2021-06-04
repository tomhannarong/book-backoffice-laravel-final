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
        'client_id' => '290383932390840',
        'client_secret' => '9b61ef28982380fec54a6abfc303f45b',
        'redirect' => 'https://book-stg.adessolab.com/callback/facebook',
    ], 
    'line' => [
        'client_id' => '1655316910',
        'client_secret' => 'e23eb9d4f0837f6379516fe6e6bbe806',
        'redirect' => 'https://book-stg.adessolab.com/callback/line',
    ], 
    'google' => [    
        'client_id' => '555999669648-4q2ed25sj0abhb2plokbccj8aaf8phcn.apps.googleusercontent.com',
        'client_secret' => 'SmH_844So66FE5SYHGHqzm2s',
        'redirect' => 'https://book-stg.adessolab.com/callback/google',
      ],

];
