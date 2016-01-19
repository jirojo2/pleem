@extends('admin.layout')

@section('title', 'Members')

@section('content')
  <h1 class="page-header">Members</h1>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>First name</th>
          <th>Last name</th>
          <th>Email</th>
          <th>Country</th>
          <th>Team</th>
          <th>Registered</th>
          <th>Birthdate</th>
          <th>Faculty/School</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($members as $member)
        <tr>
          <td>{{ $member->first_name }}</td>
          <td>{{ $member->last_name }}</td>
          <td>{{ $member->email }}</td>
          <td>{{ $member->country }}</td>
          <td>{{ $member->group->name }}</td>
          <td>{{ $member->created_at }}</td>
          <td>{{ $member->birthdate }}</td>
          <td>{{ str_limit($member->faculty, 50) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection