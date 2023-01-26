<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    /**
     * Initiates a new subscription in strava
     *
     * @return void|JsonResponse
     */
    public function initiate()
    {
        $response = Http::post(config('strava.base_url').'push_subscriptions', [
            'client_id'     => config('strava.client_id'),
            'client_secret' => config('strava.client_secret'),
            'callback_url'  => config('strava.webhook_url'),
            'verify_token'  => config('strava.verification_token'),
        ]);

        if ($response->successful()) {
            return response()->json([
                'message' => 'Subscription successfull',
                "data"    => json_decode($response->body())
            ]);
        }

        abort(400, 'There was an error completing your subscription');
    }

    /**
     * Validates the strava subscription
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validateSubscription(Request $request)
    {
        if (config('strava.verification_token') !== $request['hub_verify_token']) {
            abort(403, 'Invalid verification token');
        }
        return response()->json([
            'hub.challenge' => $request['hub_challenge']
        ]);
    }
}