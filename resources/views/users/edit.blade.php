@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2>Edit Post</h2>
		</div>
		<div class="pull-right">
			<a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
		</div>
	</div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<form action="{{ route('users.update',$user->id) }}" method="POST">
	@csrf

	@method('PUT')
	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Name:</strong>
				<input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="name">
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Email:</strong>
				<input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="password">
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Password:</strong>
				<input type="password" name="password" class="form-control" placeholder="password">
			</div>
		</div>
		@foreach($permissions as $permission)
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-check">
				<input class="form-chech-input" checked type="checkbox" value="{{ old('perm[$permission->id]') }}" name="perm[{{ $permission->id; }}]" class="form-check-input">
				<label class="form-check-label" for="flexCheckChecked">
					{{ $permission->name; }}
				</label>
			</div>
		</div>
		@endforeach
		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="btn btn-outline-success">Submit</button>
		</div>
	</div>
</form>
@endsection