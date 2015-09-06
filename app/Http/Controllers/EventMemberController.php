<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Member;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($eventId)
    {
        $members = Event::findOrFail($eventId)->members;
        return response()->json($members);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($eventId, $id)
    {
        $member = Event::findOrFail($eventId)->members()->findOrFail($id);
        return response()->json($member);
    }
}
