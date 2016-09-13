<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */


    /*
     * esto es del mailgun
     * ener en cuenta que se esta haciendo pruebas
     * 'domain' => 'sandbox4e536a6b002645d6869ce2b5a790abc4.mailgun.org',
        'secret' => env('MAILGUN_PASS'),
     *
     * */

    'mailgun' => [
        'domain' => 'sandbox4e536a6b002645d6869ce2b5a790abc4.mailgun.org',
        'secret' => env('MAILGUN_PASS'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
