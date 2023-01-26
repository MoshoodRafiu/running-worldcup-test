<?php

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/strava')->group(function () {
    Route::controller(SubscriptionController::class)->group(function () {
        Route::post('/subscribe', 'initiate');
        Route::get('/webhook',    'validateSubscription');
    });
    Route::post('/webhook',   [WebhookController::class, 'process']);
});