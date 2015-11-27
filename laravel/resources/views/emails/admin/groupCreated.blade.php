<h1>New team: {{ $group->name }}</h1>
<ul>
@foreach ($group->members as $member)
	<li>{{ $member->first_name }} {{ $member->last_name }} ({{ $member->email }})</li>
@foreach
</ul>