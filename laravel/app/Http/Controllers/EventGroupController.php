<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Group;
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

        //
        //if (Gate::denies('create-group', $event)) {
        //    abort(403);
        //}
        //

        $v = Validator::make($request, [
            'name' => 'required|max:255',
            'members' => 'required|array',
        ]);

        for ($n = 1; $n < count($request->members); $n++) {
            $v->sometimes("members.$n.email", 'required|email|max:255|unique:members', function($input) { return count($input->members >= $n); });
            $v->sometimes("members.$n.password", 'required|confirmed|min:6', function($input) { return count($input->members >= $n); });
            $v->sometimes("members.$n.first_name", 'max:255', function($input) { return count($input->members >= $n); });
            $v->sometimes("members.$n.last_name", 'max:255', function($input) { return count($input->members >= $n); });
            $v->sometimes("members.$n.birthdate", 'required|date', function($input) { return count($input->members >= $n); });
            $v->sometimes("members.$n.sex", 'required|in:m,f', function($input) { return count($input->members >= $n); });
        }

        $v->after(function($validator) {
            if (count($request->members) < 1 || count($request->members) > 3)
                $validator->errors()->add('members', 'Only 1-3 members are accepted');
        });

        if ($v->fails()) {
            return response()->json($v->errors(), 400);
        }

        // TODO: Members creation
        // IF the member exists AND the password is correct, add to the event's group

        $group = new Group($request->all());
        $group = $event->groups()->save($group);
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
