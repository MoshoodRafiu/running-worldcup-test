<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class SubscriptionService
{
    public function createWebhookSubscription()
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

    public function validateWebhookSubscription(array $payload)
    {
        if (config('strava.verification_token') !== $payload['hub_verify_token']) {
            abort(403, 'Invalid verification token');
        }
        return response()->json([
            'hub.challenge' => $payload['hub_challenge']
        ]);
    }
}
