<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '1939053793043063',
        'client_secret' => 'bf25ad9e08f883c6b55bd927da5f6e88',
        'redirect' => 'https://kuwpons.com/login/facebook/callback',
    ],

    'google' => [
        'client_id' => '605313409748-9h8a2m4kb1ed6fr1l7sqqjgdmq7qbu1j.apps.googleusercontent.com',
        'client_secret' => 'YMKNAidutlePomYH_mj6Ij40',
        'redirect' => 'https://kuwpons.com/login/google/callback',
    ],

];
