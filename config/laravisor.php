<?php

return [

    'enabled' => env('LV_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Laravisor Server (Policy Only)
    |--------------------------------------------------------------------------
    */
    'server' => env('LV_SERVER'),
    'project_key' => env('LV_PROJECT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Allowed environments
    |--------------------------------------------------------------------------
    */
    'environments' => array_filter(
        explode(',', env('LV_ENVIRONMENTS', 'production'))
    ),

    'throttle' => [
        'enabled' => true,
        'window_seconds' => 300, // 5 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification channels (local execution)
    |--------------------------------------------------------------------------
    */
    'notifications' => [
        'email' => true,
        'slack' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email recipients (requested)
    |--------------------------------------------------------------------------
    */
    'notify_emails' => array_filter(
        explode(',', env('LV_NOTIFY_EMAILS', ''))
    ),

    /*
    |--------------------------------------------------------------------------
    | Ignore exceptions
    |--------------------------------------------------------------------------
    */
    'ignore_exceptions' => [
        Illuminate\Auth\AuthenticationException::class,
        Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
    ],
];
