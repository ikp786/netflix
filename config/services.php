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
    'facebook' => [
        'client_id' => '1246649199134538',
        'client_secret' => '855557e55a29a5c2cab1b1f65da6f6bf',
        'redirect' => 'https://localhost/auth/facebook/callback',
    ],
    'google' => [
        'client_id' => '250564194475-lberhe6vvm25enroucmc3a235h3ob2al.apps.googleusercontent.com',
        'client_secret' => '93MuoPqf8OGJ4CM-59xNyv84',
        'redirect' => 'http://localhost:8000/auth/google/callback',
    ],
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
];
