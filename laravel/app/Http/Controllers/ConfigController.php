<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

use App\Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * Show config
     *
     * @return Response
     */
    public function index()
    {
        if (Gate::denies('view-config')) {
            abort(403);
        }

        $config = Config::first();

        return response()->json($config);
    }

    /**
     * Update config via POST
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('set-config')) {
            abort(403);
        }

        $config = Config::first();
        $config->update($request->only('registration_enabled'));
        return response()->json($config);
    }
}
