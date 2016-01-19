@extends('admin.layout')

@section('title', 'Teams')

@section('sidebar')
  @parent
  <ul class="nav nav-sidebar">
    <li><a href="/admin/teams/csv">Export CSV</a></li>
  </ul>
@endsection

@section('content')
  <h1 class="page-header">Teams</h1>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Team Name</th>
          <th>Registered at</th>
          <th>Members</th>
          <th>Idea Name</th>
          <th>Idea Repo</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($teams as $team)
        <tr>
          <td>{{ $team->name }}</td>
          <td>{{ $team->created_at }}</td>
          <td>
            @foreach ($team->members as $member)
              {{ $member->first_name }}
              {{ $member->last_name }}
              <br>
            @endforeach
          </td>
          <td>
            @if ($team->idea)
              {{ str_limit($team->idea->name, 50)}}
            @else
              -
            @endif
          </td>
          <td>
            @if ($team->idea)
              {{ $team->idea->repository }}
            @else
              -
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection