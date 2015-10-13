<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

use App\Event;
use App\Score;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventGroupScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $eventId
     * @param  int  $groupId
     * @return Response
     */
    public function index($eventId, $groupId)
    {
        $event = Event::findOrFail($eventId);
        $group = $event->groups()->findOrFail($groupId);
        $scores = $group->scores();

        if (Gate::denies('group-private-scores', $event, $group)) {
            $scores = $scores->where('public', true)->get();
        }
        else {
            $scores = $scores->get();
        }

        return response()->json($scores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  int  $eventId
     * @param  int  $groupId
     * @return Response
     */
    public function store(Request $request, $eventId, $groupId)
    {
        $event = Event::findOrFail($eventId);
        $group = $event->groups()->findOrFail($groupId);

        //@TODO: Validate we are a judge for this event
        //
        //if (Gate::denies('create-group-score', $event, $group)) {
        //    abort(403);
        //}
        //

        $this->validate($request, [
            'name' => 'required|max:255',
            'score' => 'required|numeric'
        ]);

        //@TODO: Delete previous scores from this judge to this group?
        //       Only those with the same score.name?

        $score = new Score($request->all());
        $score->judge()->associate(1); // @TODO get judge's member id from $user
        $score->event()->associate($eventId);
        $score->group()->associate($groupId);
        $score->save();
        return response()->json($score);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $eventId
     * @param  int  $groupId
     * @param  int  $id
     * @return Response
     */
    public function show($eventId, $groupId, $id)
    {
        $score = Event::findOrFail($eventId)->groups()
                    ->findOrFail($groupId)->scores()
                    ->findOrFail($id);
        return response()->json($score);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $eventId
     * @param  int  $groupId
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $eventId, $groupId, $id)
    {
        //@TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($eventId, $groupId, $id)
    {
        $score = Score::findOrFail($id);

        //
        //if (Gate::denies('destroy-group', $group)) {
        //    abort(403);
        //}
        //

        $group->delete();
        return response()->json("ok");
    }
}
