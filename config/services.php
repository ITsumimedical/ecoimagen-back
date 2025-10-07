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

    'fomag' => [
        'client_id' => env('FOMAG_CLIENT_ID'),
        'client_secret' => env('FOMAG_CLIENT_SECRET'),
        'api_url' => env('FOMAG_API_URL', 'http://localhost:8001/api'),
        'user_fomag_interoperabilidad_id' => env('USER_FOMAG_INTEROPERABILIDAD_ID', '865200'),
    ],

    'medicina_integral' => [
        'client_id' => env('MEDICINA_INTEGRAL_CLIENT_ID'),
        'client_secret' => env('MEDICINA_INTEGRAL_CLIENT_SECRET'),
        'api_url' => env('MEDICINA_INTEGRAL_API_URL', 'http://localhost:8002/api'),
    ],

    'sispro' => [
        'api_url' => env('SISPRO_URL_CUV'),
    ],

    'app_name' => [
        'nombre_app' => env('APP_URL'),
    ],

    'pusher' => [
        'channel' => env('PUSHER_CHANNEL', 'sumimedical'),
    ],

    'keiron' => [
        'token_envio_keiron' => env('TOKEN_ENVIO_KEIRON'),
        'flow_keiron' => env('FLOW_KEIRON'),
        'status_board' => env('ESTATUS_BOARD'),
        'transition_send' => env('TRANSITION_SEND'),
        'status_cancelado' => env('STATUS_CANCELADO'),
        'transition_cancelado' => env('TRANSITION_CANCELADO')
    ],

    'codepyme' => [
        'api_key' => env('CODEPYME_API_KEY'),
        'api_url' => env('CODEPYME_API_URL', 'https://test.apidian.app/api/ubl2.1'),
    ],

];
