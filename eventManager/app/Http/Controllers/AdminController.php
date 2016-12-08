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

    public function membersCsv()
    {
        if (Gate::denies('admin')) {
            Auth::logout();
            return redirect('/admin/login');
        }

        $members = Member::with('group')->get();
        $columns = ['id', 'email', 'first_name', 'last_name', 'country', 'group.name', 'created_at', 'birthdate', 'faculty'];
        $headers = ['ID', 'Email', 'First Name', 'Last Name', 'Country', 'Team Name', 'Registered At', 'Birthdate', 'Faculty/School'];
        $csv = $this->exportCsv($members, $columns, $headers);
        $csvName = 'eca-members-'.date('Y-m-d-His').'.csv';

        return response($csv, 200, [
            'Content-type'=>'text/csv',
            'Content-Disposition'=>sprintf('attachment; filename="%s"', $csvName),
            'Content-Length'=>strlen($csv)
        ]);
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

    public function teamsCsv()
    {
        if (Gate::denies('admin')) {
            Auth::logout();
            return redirect('/admin/login');
        }

        $teams = Group::with('idea')->get();
        $columns = ['id', 'name', 'created_at', 'idea.name', 'idea.repository', 'idea.description', 'idea.created_at'];
        $headers = ['ID', 'Name', 'Registered At', 'Idea Name', 'Idea Repository', 'Idea Description', 'Idea Registered At'];
        $csv = $this->exportCsv($teams, $columns, $headers);
        $csvName = 'eca-teams-'.date('Y-m-d-His').'.csv';

        return response($csv, 200, [
            'Content-type'=>'text/csv',
            'Content-Disposition'=>sprintf('attachment; filename="%s"', $csvName),
            'Content-Length'=>strlen($csv)
        ]);
    }

    /**
     * Generates csv output from parameters
     */
    public function exportCsv($collection, $columns, $headers)
    {
        $separator = ';';
        $newline = "\n";
        $csv = '';

        foreach ($headers as $header)
        {
            $csv .= $header.$separator;
        }
        $csv = rtrim($csv, $separator);
        $csv .= $newline;

        foreach ($collection as $i)
        {
            foreach ($columns as $column)
            {
                if (strpos($column, '.') !== false)
                {
                    $e = $i;
                    foreach (explode('.', $column) as $p)
                        $e = $e[$p];
                    $csv .= str_replace("\n", '', $e).$separator;
                }
                else
                {
                    $csv .= str_replace("\n", '', $i[$column]).$separator;
                }
            }
            $csv = rtrim($csv, $separator);
            $csv .= $newline;
        }
        return $csv;
    }
}
