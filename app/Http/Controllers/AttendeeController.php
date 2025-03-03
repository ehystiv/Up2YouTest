<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Requests\UpdateAttendeeRequest;
use App\Models\Attendee;
use Symfony\Component\HttpFoundation\Response;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Attendee::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendeeRequest $request)
    {
        $attendee = new Attendee;

        $attendee->fill($request->validated());
        $attendee->save();

        return response()->json($attendee, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendee $attendee)
    {
        return $attendee;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendeeRequest $request, Attendee $attendee)
    {
        $attendee->fill($request->validated());
        $attendee->save();

        return response()->json($attendee, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendee $attendee)
    {
        $attendee->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
