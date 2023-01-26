<?php

return [
    'base_url'           => env('STRAVA_BASE_URL'),
    'client_id'          => env('STRAVA_CLIENT_ID'),
    'client_secret'      => env('STRAVA_CLIENT_SECRET'),
    'verification_token' => env('STRAVA_VERIFICATION_TOKEN'),
    'webhook_url'        => env('APP_URL').'/api/webhook',
];