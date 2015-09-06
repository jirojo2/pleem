<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Group;
use App\Member;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventGroupMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($eventId, $groupId)
    {
        $members = Event::findOrFail($eventId)->groups()->findOrFail($groupId)->members;
        return response()->json($members);
    }

    /**
     * Associate the specified member resource to the group-event tuple
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $eventId, $groupId)
    {
        $event = Event::findOrFail($eventId);
        $group = $event->groups()->findOrFail($groupId);

        //
        //if (Gate::denies('attach-member', $event, $group)) {
        //    abort(403);
        //}
        //

        $this->validate($request, [
            'role' => 'required',
            'member' => 'required|exists:members,id'
        ]);

        $member = Member::findOrFail($request->member);

        try {
            $member->events()->attach($eventId, [ 'role' => $request->role, 'group_id' => $group->id ] );
            return response()->json("ok");
        }
        catch (\Illuminate\Database\QueryException $e) {
            return response()->json("that member is already in the event");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($eventId, $groupId, $id)
    {
        $member = Event::findOrFail($eventId)->groups()
                    ->findOrFail($groupId)->members()
                    ->findOrFail($id);
        return response()->json($member);
    }

    /**
     * Dissasociate the specified member resource from the group-event tuple.
     *
     * @param  int  $eventId
     * @param  int  $groupId
     * @param  int  $memberId
     * @return Response
     */
    public function destroy($eventId, $groupId, $memeberId)
    {
        $event = Event::findOrFail($eventId);
        $group = $event->groups()->findOrFail($groupId);
        $member = $group->members()->findOrFail($memeberId);

        //
        //if (Gate::denies('detach-member', $event, $group, $member)) {
        //    abort(403);
        //}
        //

        $member->events()->detach($event->id);
        return response()->json("ok");
    }
}
