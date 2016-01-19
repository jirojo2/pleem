<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Gate;
use App\Group;
use App\Member;
use App\Idea;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display admin index.
     *
     * @return Response
     */
    public function index()
    {
        if (Gate::denies('admin')) {
            Auth::logout();
            return redirect('/admin/login');
        }

        // Display total numbers
        $groups = Group::count();
        $members = Member::count();
        $ideas = Idea::count();

        return view('admin.dashboard', [
            'groups' => $groups,
            'members' => $members,
            'ideas' => $ideas
        ]);
    }

    public function login()
    {
        return view('admin.login');
    }

    public function members()
    {
        if (Gate::denies('admin')) {
            Auth::logout();
            return redirect('/admin/login');
        }

        $members = Member::with('group')->get();

        return view('admin.members', [ 'members' => $members ]);
    }

    public function teams()
    {
        if (Gate::denies('admin')) {
            Auth::logout();
            return redirect('/admin/login');
        }

        $teams = Group::with('idea')->get();

        return view('admin.teams', [ 'teams' => $teams ]);
    }
}
