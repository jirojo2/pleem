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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($eventId, $groupId, $id)
    {
        $member = Event::findOrFail($eventId)->groups()->findOrFail($groupId)->members()->findOrFail($id);
        return response()->json($member);
    }

    /**
     * Dissasociate the specified member resource from the group-event tuple.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
