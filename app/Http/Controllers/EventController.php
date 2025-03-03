<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function show(Event $event)
    {
        return $event;
    }

    public function store(StoreEventRequest $request)
    {
        $event = new Event();

        $event->fill($request->validated());
        $event->save();

        return response()->json($event, Response::HTTP_CREATED);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->fill($request->validated());
        $event->save();

        return response()->json($event, Response::HTTP_OK);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
