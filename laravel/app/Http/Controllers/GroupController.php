<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Hash;
use Mail;
use Validator;
use App\Event;
use App\Group;
use App\Member;
use App\Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $groups = Group::all();
        return response()->json($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $cfg = Config::first();

        // Check config if registration is enabled
        if (!$cfg->registration_enabled) {
            return response()->json(["msg" => "registrations are disabled"], 403);
        }

        $v = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:groups',
            'members' => 'required|array',
        ]);

        for ($n = 0; $n < count($request->members); $n++) {
            $v->sometimes("members.$n.email", 'required|email|max:255', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.password", 'required|confirmed|min:6', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.first_name", 'required|max:255', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.last_name", 'required|max:255', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.birthdate", 'required|date', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.sex", 'required|in:m,f', function($input) use($n) { return count($input->members >= $n); });
            $v->sometimes("members.$n.country", 'required', function($input) use($n) { return count($input->members >= $n); });
            //$v->sometimes("members.$n.cv", 'required|mimes:pdf', function($input) use($n) { return count($input->members >= $n); });
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
        $group->save();

        // create or register to the group all the members
        foreach ($request->members as $m) {
            $qm = Member::where('email', $m['email']);
            if (!$qm->exists()) {
                $qm = new Member($m);
                $qm->password = Hash::make($m['password']);

                $group->members()->save($qm);

                // Handle cv PDF
                //if ($m['cv']->isValid()) {
                //    $m['cv']->move(storage_path('app/cvs'), $qm->id.'.pdf');
                //}
            }
        }

        Mail::send('emails.admin.groupCreated', ['group' => $group], function ($m) use ($group, $cfg) {
            $m->from('eca-noreply@eestec.net', 'EESTEC Android Competition');
            $m->to($cfg->admin_email, 'ECA Admin')->subject('New group registered!');
        });

        return response()->json($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $group = Group::with('members')
                    ->with('scores')
                    ->with('idea')
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
    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if (Gate::denies('edit-group', $event, $group)) {
            abort(403);
        }

        //$this->validate($request, [
        //]);

        // this does nothing atm, the name is not allowed to be changed

        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);

        if (Gate::denies('destroy-group', $event, $group)) {
            abort(403);
        }

        $group->delete();
        return response()->json("ok");
    }
}
