<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\LC;
use App\Event;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LCEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($lcId)
    {
        $events = LC::findOrFail($lcId)->events()->paginate(10);
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $lcId)
    {
        $lc = LC::findOrFail($lcId);

        //
        //if (Gate::denies('create-event', $lc)) {
        //    abort(403);
        //}
        //

        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $event = new Event($request->all());
        $event = $lc->events()->save($event);

        return response()->json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($lcId, $id)
    {
        $event = LC::findOrFail($lcId)->events()->findOrFail($id);
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $lcId, $id)
    {
        $event = LC::findOrFail($lcId)->events()->findOrFail($id);

        //
        //if (Gate::denies('edit-event', $event)) {
        //    abort(403);
        //}
        //

        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $event->fill($request->all());
        $event->lc()->associate($lcId);
        $event->save();

        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $event = LC::findOrFail($lcId)->events()->findOrFail($id);

        //
        if (Gate::denies('destroy-event', $event)) {
            abort(403);
        }

        $event->delete();
        return response()->json("ok");
    }
}
