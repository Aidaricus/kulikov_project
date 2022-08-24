@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2>Create new category</h2>
		</div>
		<div class="pull-right">
			<a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
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

<form action="{{ route('categories.store') }}" method="POST">
	@csrf
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Name:</strong>
				<input type="text" name="name" class="form-control" placeholder="name" value="{{ old('name') }}">
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<strong>Is Visible:</strong>
			<div class="form-check">
				<input class="form-chech-input" checked type="checkbox" name="is_visible" class="form-check-input">
				<label class="form-check-label" for="flexCheckDefault">
					Yes
				</label>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="btn btn-outline-success">Submit</button>
		</div>
	</div>
</form>
@endsection