<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'unifi' => [
        'uri' => env('UNIFI_ACCESS_URI', 'https://192.168.1.1:12445'),
        'api_key' => env('UNIFI_ACCESS_API_KEY', null),
        'ssl_verify' => env('UNIFI_ACCESS_SSL_VERIFY', false),
    ],
];
