<?php

namespace App\Http\Services;

use Exception;
use App\Models\Activity;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    /**
     * Run the webhook process
     *
     * @param array $request
     * @return void
     */
    public function process(array $request)
    {
        if ($request['object_type'] === 'activity') {
            $updates = $request['updates'];
            $objectId = $request['object_id'];

            try {
                if ($request['aspect_type'] === 'delete') {
                    $activity = Activity::where('starva_id', $objectId);
                    if ($activity) $activity->delete();
                } else {
                    $data = Arr::only($updates, [
                        'name', 'distance', 'moving_time',
                        'elapsed_time', 'total_elevation_gain',
                        'type', 'sport_type', 'kudos_count',
                        'average_speed', 'max_speed',
                        'description', 'calories'
                    ]);

                    $data['start_date'] = Carbon::parse($updates['start_date']);

                    Activity::updateOrCreate(['starva_id' => $objectId], $data);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
