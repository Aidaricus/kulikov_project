@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">

		</div>
		@can('user-create')
		<div class="pull-right">
			<a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
		</div>
		@endcan
	</div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
	<p>{{ $message }}</p>
</div>
@endif

<table class="table">
	<tr>
		<th>name</th>
		<th>email</th>
	</tr>
	@foreach ($users as $user)
	<tr>
		<td>{{ $user->name ?? 'None' }}</td>
		<td>{{ $user->email ?? 'None' }}</td>
		<td>
			<a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a>
			@can('user-update', $user)
			<a class="btn btn-warning" href="{{ route('users.edit', $user->id) }}">Edit</a>
			@endcan
			@can('user-delete', $user)
			<form action="{{ route('users.destroy', $user->id) }}" method="POST">
				@csrf
				@method('DELETE')
				<button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger">Delete</button>
			</form>
			@endcan
		</td>
	</tr>
	@endforeach
</table>

@endsection