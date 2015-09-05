<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\LC;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lcs = LC::all();
        return response()->json($lcs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        if (Gate::denies('create-lc', $event)) {
            abort(403);
        }
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
        if (Gate::denies('create-lc', $event)) {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $lc = LC::findOrFail($id);
        return response()->json($lc);
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
        if (Gate::denies('edit-lc', $event)) {
            abort(403);
        }
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
        if (Gate::denies('edit-lc', $event)) {
            abort(403);
        }
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
        if (Gate::denies('destroy-lc', $event)) {
            abort(403);
        }
    }
}
