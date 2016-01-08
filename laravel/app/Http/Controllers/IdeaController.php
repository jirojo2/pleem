<?php

namespace App\Http\Controllers;

use Auth;
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

        $idea = Auth::user()->group->idea;

        return response()->json($idea);
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

        $this->validate($request, [
            'name' => 'required|unique:ideas|max:255',
            'repository' => 'required|max:255',
            'description' => 'required',
        ]);

        $idea = new Idea($request->only('name', 'description', 'repository'));
        $idea = Auth::user()->group->idea()->save($idea);

        return response()->json($idea);
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

        $this->validate($request, [
            'name' => 'required|unique:ideas,name,'.$idea->name.'|max:255',
            'repository' => 'required|max:255',
            'description' => 'required',
        ]);

        $idea->name = $request->name;
        $idea->repository = $request->repository;
        $idea->description = $request->description;
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
