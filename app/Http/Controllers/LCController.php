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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        //if (Gate::denies('create-lc')) {
        //    abort(403);
        //}

        $this->validate($request, [
            'city' => 'required|max:255',
            'country' => 'required|max:255'
        ]);

        $lc = new LC($request->all());
        $lc->save();

        return response()->json($lc);
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
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $lc = LC::findOrFail($id);

        //
        if (Gate::denies('edit-lc', $lc)) {
            abort(403);
        }

        $this->validate($request, [
            'city' => 'required|max:255',
            'country' => 'required|max:255'
        ]);

        $lc->fill($request->all());
        $lc->save();
        return response()->json($lc);
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
