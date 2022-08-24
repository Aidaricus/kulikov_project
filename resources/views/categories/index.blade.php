@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-15 margin-tb">
		<div class="pull-left">

		</div>
		<!-- @can('product-create') -->
		<div class="pull-right">
			<a class="btn btn-success" href="{{ route('categories.create') }}"> Create New Category</a>
		</div>
		<!-- @endcan -->
	</div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
	<p>{{ $message }}</p>
</div>
@endif

<table class="table">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">name</th>
			<th scope="col">is visible</th>
		</tr>
	</thead>
	<tbody>
		@foreach($categories as $category)
		<tr>
			<th scope="row">{{ $category->id }}</th>
			<th scope="row">{{ $category->name }}</th>
			@if($category->id)
			<th scope="row">Yes</th>
			@else
			<th scope="row">No</th>
			@endif
			<th><a class="btn btn-info" href="{{ route('categories.show', $category->id) }}">Show</a></th>

			<th><a class="btn btn-warning" href="{{ route('categories.edit', $category->id) }}">Edit</a></th>
			<th>
				<form action="{{ route('categories.destroy', $category->id) }}" method="POST">
					@csrf
					@method('DELETE')
					<button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-outline-danger">Delete</button>
				</form>
			</th>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection