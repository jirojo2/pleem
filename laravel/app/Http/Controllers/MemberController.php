<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

use App\Member;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $members = Member::all();
        return response()->json($members);
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
        //if (Gate::denies('create-member')) {
        //    abort(403);
        //}
        //

        // @TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
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
        $member = Member::findOrFail($id);

        if (Gate::denies('edit-member', $member)) {
            abort(403);
        }

        $member->first_name = $request->input("first_name");
        $member->last_name = $request->input("last_name");
        $member->birthdate = $request->input("birthdate");
        $member->country = $request->input("country");
        $member->sex = $request->input("sex");
        $member->faculty = $request->input("faculty");
        $member->years_study = $request->input("years_study");
        $member->study_level = $request->input("study_level");
        $member->save();
        return response()->json($member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        if (Gate::denies('destroy-member')) {
            abort(403);
        }

        $member->delete();
        return response()->json("ok");
    }

    /**
     * Shows the user's CV
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function showCV(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        if (Gate::denies('view-cv', $member)) {
            abort(403);
        }

        $cv = storage_path("app/cvs/$id.pdf");

        if (file_exists($cv)) {
            return response()->download(cv);
        }
        else {
            abort(404);
        }
    }

    /**
     * Upload the user's CV
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function uploadCV(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        if (Gate::denies('upload-cv', $member)) {
            abort(403);
        }

        $this->validate($request, [
            'cv' => 'required|mimes:pdf',
        ]);

        // Handle cv PDF
        if ($request->file('cv')->isValid()) {
            $request->file('cv')->move(storage_path('app/cvs'), $id.'.pdf');
            return response()->json("ok");
        }
        else {
            abort(400);
        }
    }
}
