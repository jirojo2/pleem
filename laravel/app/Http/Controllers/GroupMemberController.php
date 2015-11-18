<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Group;
use App\Member;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($groupId)
    {
        $members = Group::findOrFail($groupId)->members;
        return response()->json($members);
    }

    /**
     * Associate the specified member resource to the group tuple
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $groupId)
    {
        // Check config if registration is enabled
        if (!Config::first()->registration_enabled) {
            return response()->json(["msg" => "registrations are disabled"], 403);
        }

        $group = Group::findOrFail($groupId);

        if (Gate::denies('attach-member', $group)) {
            abort(403);
        }

        $this->validate($request, [
            'member.email' => 'required|unique|email|max:255',
            'member.password' => 'required|confirmed|min:6',
            'member.first_name' => 'required|max:255',
            'member.last_name' => 'required|max:255',
            'member.birthdate' => 'required|date',
            'member.sex' => 'required|in:m,f'
        ]);

        $member = new Member($request->input('member'));
        $member->password = Hash::make($request->input('member.password'));
        $member->save();

        try {
            $member->groups()->attach($group->id);
            return response()->json("ok");
        }
        catch (\Illuminate\Database\QueryException $e) {
            return response()->json("error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($groupId, $id)
    {
        $member = Group::findOrFail($groupId)
                    ->members()
                    ->findOrFail($id);
        return response()->json($member);
    }

    /**
     * Dissasociate the specified member resource from the group-event tuple.
     *
     * @param  int  $groupId
     * @param  int  $memberId
     * @return Response
     */
    public function destroy($groupId, $memeberId)
    {
        $group = Group::findOrFail($groupId);
        $member = $group->members()->findOrFail($memeberId);

        //
        //if (Gate::denies('detach-member', $event, $group, $member)) {
        //    abort(403);
        //}
        //

        $member->groups()->detach();
        return response()->json("ok");
    }
}
