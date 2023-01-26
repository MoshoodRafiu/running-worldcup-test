<?php

namespace App\Http\Controllers;

use App\Http\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService)
    {
    }

    /**
     * Initiates a new subscription in strava
     *
     * @return void|JsonResponse
     */
    public function initiate()
    {
        $this->subscriptionService->createWebhookSubscription();
    }

    /**
     * Validates the strava subscription
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validateSubscription(Request $request)
    {
        $this->subscriptionService->validateWebhookSubscription($request->all());
    }
}