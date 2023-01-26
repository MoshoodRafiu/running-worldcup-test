<?php

namespace Tests\Feature;

use App\Http\Services\WebhookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebhookServiceTest extends TestCase
{
    use RefreshDatabase;

    protected WebhookService $webhookService;

    public function setUp(): void
    {
        parent::setUp();
        $this->webhookService = new WebhookService;
    }

    /**
     * A test to check that activies are stored.
     *
     * @return void
     */
    public function test_it_stores_activity()
    {
        $payload = $this->getSamplePayload('create');
        $this->webhookService->process($payload);
        $this->assertDatabaseCount('activities', 1);
    }

    /**
     * A test to check that activies are updated.
     *
     * @return void
     */
    public function test_it_updates_activity()
    {
        $updatedName = "Name has been updated";
        $payload = $this->getSamplePayload('update');
        $payload['updates']['name'] = $updatedName;
        $this->webhookService->process($payload);
        $this->assertDatabaseHas('activities', [
            'name' => $updatedName
        ]);
    }

    /**
     * A test to check that activies are deleted.
     *
     * @return void
     */
    public function test_it_deletes_activity()
    {
        $payload = $this->getSamplePayload('delete');
        $this->webhookService->process($payload);
        $this->assertDatabaseCount('activities', 0);
    }

    private function getSamplePayload(string $type): array
    {
        return json_decode('{
            "aspect_type": "'. $type .'",
            "event_time": 1516126040,
            "object_id": 1360128428,
            "object_type": "activity",
            "owner_id": 134815,
            "subscription_id": 120475,
            "updates": {
                "name": "Test",
                "distance": 0,
                "moving_time": 45,
                "elapsed_time": 45,
                "total_elevation_gain": 0,
                "type": "Run",
                "sport_type": "Run",
                "id": 8453942994,
                "start_date": "2023-01-24T08:00:00Z",
                "average_speed": 0,
                "max_speed": 0,
                "description": null,
                "kudos_count": 10,
                "calories": 0
            }
        }', true);
    }
}
