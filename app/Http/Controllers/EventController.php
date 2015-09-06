<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

use App\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Convenience Controller to access the event resource without
 * specifiying its parent LC Id
 */
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $events = Event::paginate(10);
        return response()->json($events);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }
}
