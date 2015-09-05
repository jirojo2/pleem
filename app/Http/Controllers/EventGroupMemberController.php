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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
