<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Services\WebhookService;

class WebhookController extends Controller
{
    public function __construct(protected WebhookService $webhookService)
    {
    }

    /**
     * Process the webhook request
     *
     * @param Request $request
     * @return void
     */
    public function process(Request $request)
    {
        $this->webhookService->process($request->all());
    }
}
