<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use Validator;
use App\Event;
use App\Group;
use App\Member;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($eventId)
    {
        $groups = Event::findOrFail($eventId)->groups;
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $v = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:groups',
            'members' => 'required|array',
        ]);

        for ($n = 0; $n < count($request->members); $n++) {
            $v->sometimes("members.$n.email", 'required|email|max:255', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.password", 'required|confirmed|min:6', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.first_name", 'max:255', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.last_name", 'max:255', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.birthdate", 'required|date', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.sex", 'required|in:m,f', function($input) use($n) { return count($input->members >= $n); });
        }

        $v->after(function($validator) use ($request) {
            if (count($request->members) < 1 || count($request->members) > 3)
                $validator->errors()->add('members', 'Only 1-3 members are accepted');
        });

        if ($v->fails()) {
            return response()->json($v->errors(), 400);
        }

        // validate all members have correct auth or do not exist yet
        foreach ($request->members as $m) {
            $qm = Member::where('email', $m['email']);
            if ($qm->exists()) {
                // Check password
                if (!Auth::once(['email' => $m['email'], 'password' => $m['password']])) {
                    return response()->json([
                            "msg" => "User already exists, and password is incorrect",
                            "offender" => $m['email']
                        ], 400);
                }
            }
        }

        $group = new Group($request->only('name'));
        $group = $event->groups()->save($group);

        // create or register to the group all the members
        foreach ($request->members as $m) {
            $qm = Member::where('email', $m['email']);
            if (!$qm->exists()) {
                $qm = new Member($m);
                $qm->password = Hash::make($m['password']);
                $qm->save();
            }
            else {
                $qm = $qm->first();
            }
            $qm->groups()->attach($group->id, ['event_id' => $eventId]);
        }

        return response()->json($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($eventId, $id)
    {
        $group = Event::findOrFail($eventId)
                    ->groups()
                    ->with('members')
                    ->with('scores')
                    ->findOrFail($id);
        return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $eventId, $id)
    {
        $event = Event::findOrFail($eventId);
        $group = $event->groups()->findOrFail($id);

        //
        //if (Gate::denies('edit-group', $event, $group)) {
        //    abort(403);
        //}
        //

        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $group->fill($request->all());
        $group->save();
        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($eventId, $id)
    {
        $event = Event::findOrFail($eventId);
        $group = $event->groups()->findOrFail($id);

        //
        //if (Gate::denies('destroy-group', $event, $group)) {
        //    abort(403);
        //}
        //

        $group->delete();
        return response()->json("ok");
    }
}
