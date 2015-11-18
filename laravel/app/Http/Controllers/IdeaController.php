<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

use App\Idea;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Gate::denies('list-ideas')) {
            abort(403);
        }

        $ideas = Idea::all();

        return response()->json($ideas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('create-idea')) {
            abort(403);
        }

        $idea = new Idea($request->only('name', 'description', 'modules', 'platform'));
        $idea = $idea->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $idea = Idea::findOrFail($id);

        if (Gate::denies('view-idea', $idea)) {
            abort(403);
        }

        return response()->json($idea);
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
        $idea = Idea::findOrFail($id);

        if (Gate::denies('edit-idea', $idea)) {
            abort(403);
        }

        $idea->name = $request->name;
        $idea->description = $request->description;
        $idea->modules = $request->modules;
        $idea->platform = $request->platform;
        $idea->save();

        return response()->json($idea);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $idea = Idea::findOrFail($id);

        if (Gate::denies('destroy-idea', $idea)) {
            abort(403);
        }

        $idea->delete();
        return response()->json("ok");
    }
}
