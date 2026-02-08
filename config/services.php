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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_REDIRECT_URI'),
    ],

    // Instagram driver is not supported by default, remove config to avoid errors
    /*
    'instagram' => [
        'client_id' => env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => env('INSTAGRAM_CLIENT_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT_URI'),
    ],
    */

    // TikTok driver is not supported by default, remove config to avoid errors
    /*
    'tiktok' => [
        'client_id' => env('TIKTOK_CLIENT_ID'),
        'client_secret' => env('TIKTOK_CLIENT_SECRET'),
        'redirect' => env('TIKTOK_REDIRECT_URI'),
    ],
    */

    // KingsChat driver is not supported by default, remove config to avoid errors
    /*
    'kingschat' => [
        'client_id' => env('KINGSCHAT_CLIENT_ID'),
        'client_secret' => env('KINGSCHAT_CLIENT_SECRET'),
        'redirect' => env('KINGSCHAT_REDIRECT_URI'),
    ],
    */

    'commerce' => [
        'api_url' => env('COMMERCE_API_URL'),
        'api_key' => env('COMMERCE_API_KEY'),
        'api_secret' => env('COMMERCE_API_SECRET'),
        'jwt_issuer' => env('COMMERCE_JWT_ISSUER', 'department-a'),
        'jwt_audience' => env('COMMERCE_JWT_AUDIENCE', 'department-b'),
        'jwt_ttl' => env('COMMERCE_JWT_TTL', 3600),
        'timeout' => 30,
        'retry_attempts' => 3,
    ],

];
