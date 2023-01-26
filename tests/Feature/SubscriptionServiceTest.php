<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Services\SubscriptionService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class SubscriptionServiceTest extends TestCase
{
    protected SubscriptionService $subscriptionService;

    public function setUp(): void
    {
        parent::setUp();
        $this->subscriptionService = new SubscriptionService;
    }

    /**
     * A test to check that subsciption is initiated
     *
     * @return void
     */
    public function test_it_initiates_subscription()
    {
        Http::fake();
        $expected = 'Subscription successfull';
        $response = $this->subscriptionService->createWebhookSubscription();
        $this->assertEquals($expected, $response['message']);
    }

    /**
     * A test to check that subsciption fails to initiate
     *
     * @return void
     */
    public function test_it_fails_to_initiate_subscription()
    {
        $this->expectExceptionMessage('There was an error completing your subscription');
        Http::fake([
            '*' => Http::response(['status' => 'failed'], 400)
        ]);
        $this->subscriptionService->createWebhookSubscription();
    }

    /**
     * A test to check that subsciption is validated
     *
     * @return void
     */
    public function test_it_validates_subscription()
    {
        $challenge = 'test12345';
        $payload = [
            'hub_challenge'    => $challenge,
            'hub_verify_token' => "RUNNINGWORLDCUPTEST"
        ];
        $response = $this->subscriptionService->validateWebhookSubscription($payload);
        $this->assertEquals($challenge, $response['hub.challenge']);
    }

    /**
     * A test to check that subsciption is not validated
     *
     * @return void
     */
    public function test_it_fails_to_validate_subscription_token()
    {
        $this->expectExceptionMessage('Invalid verification token');
        $payload = [
            'hub_verify_token' => "RUNNINGWORLDCUP"
        ];
        $this->subscriptionService->validateWebhookSubscription($payload);
    }
}
