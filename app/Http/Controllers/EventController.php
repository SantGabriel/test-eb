<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController
{
    public function __construct(private EventService $eventService)
    {
    }

    public function event(Request $request)
    {
        $event = Event::load($request->all());
        $result = $this->eventService->event($event);
        if($result !== false)
            return response()->json($result, 200);
        else
            return response()->json(0, 404);
    }
}
