<?php

$service = [

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
       'client_id'     => env('FACEBOOK_ID'),
       'client_secret' => env('FACEBOOK_SECRET'),
       'redirect'      => env('FACEBOOK_CALLBACKURL'),
    ],
];
if ($_SERVER['HTTP_HOST'] == "siyoz.net" && preg_match("!^/([_\w]+)!", $_SERVER['REQUEST_URI'], $matches)) {
    $service['facebook']['redirect'] = str_replace("/[apl]/", "/".$matches[1]."/", $service['facebook']['redirect']);
}
if (preg_match("/^([\w]*).siyoz.net/", $_SERVER['HTTP_HOST'], $matches)) {
    $service['facebook']['redirect'] = "http://".$matches[1].".siyoz.net/facebook/callback";
}
if (preg_match("/^poke./", $_SERVER['HTTP_HOST'])) {
//if (preg_match("/^poke./", \Request::server('HTTP_HOST'))) {
    $service['facebook'] = [
       'client_id'     => env('POKE_FACEBOOK_ID'),
       'client_secret' => env('POKE_FACEBOOK_SECRET'),
       'redirect'      => env('POKE_FACEBOOK_CALLBACKURL'),
    ];
} elseif (preg_match("/^game./", $_SERVER['HTTP_HOST'])) {
    $service['facebook'] = [
       'client_id'     => env('GAME_FACEBOOK_ID'),
       'client_secret' => env('GAME_FACEBOOK_SECRET'),
       'redirect'      => env('GAME_FACEBOOK_CALLBACKURL'),
    ];
}
return $service;
