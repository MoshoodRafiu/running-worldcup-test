<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * process the webhook request
     *
     * @param Request $request
     * @return void
     */
    public function process(Request $request)
    {
        if ($request['object_type'] === 'activity') {
            $updates = $request['updates'];

            $data = Arr::only($updates, [
                'name', 'distance', 'moving_time',
                'elapsed_time', 'total_elevation_gain',
                'type', 'sport_type', 'start_date',
                'kudos_count', 'average_speed', 'max_speed',
                'description', 'calories'
            ]);

            try {
                if ($request['aspect_type'] === 'delete') {
                    $activity = Activity::where('starva_id', $request['object_id']);
                    if ($activity) $activity->delete();
                } else {
                    Activity::updateOrCreate(['starva_id' => $request['object_id']], $data);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
