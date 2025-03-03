<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\SubscribeToEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Mail\ConfirmSubscrption;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Support\Facades\Mail;
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
        $event = new Event;

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

    public function subscribe(SubscribeToEventRequest $request)
    {
        $event = Event::find($request->input('event'));

        if ($event->attendees->count() === $event->max_attendees) {
            return response()->json(['message' => 'Event is full'], Response::HTTP_BAD_REQUEST);
        }

        $attendee = Attendee::find($request->input('attendee'));

        if ($event->attendees->contains($attendee)) {
            return response()->json(['message' => 'Attendee is already subscribed'], Response::HTTP_BAD_REQUEST);
        }

        $event->attendees()->attach($attendee);

        Mail::to($attendee->email)->send(new ConfirmSubscrption($attendee, $event));

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
