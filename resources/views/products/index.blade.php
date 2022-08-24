@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-15 margin-tb">
		<div class="pull-left">

		</div>
		<!-- @can('product-create') -->
		<div class="pull-right">
			<a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
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
			<th scope="col">category id</th>
			<th scope="col">description</th>
			<th scope="col">price</th>
			<th scope="col">photo</th>
		</tr>
	</thead>
	<tbody>
		@foreach($products as $product)
		<tr>
			<th scope="row">{{ $product->id }}</th>
			<td>{{ $product->name }}</td>
			<td>{{ $product->category_id }}</td>
			<td>{{ $product->description }}</td>
			<td>{{ $product->price }}</td>
			<td><img src="storage/{{ $product->photo_src }}" class="img-thumbnail" alt="{{ $product->name }}_image"></td>
			<th><a class="btn btn-info" href="{{ route('products.show', $product->id) }}">Show</a></th>

			<th><a class="btn btn-warning" href="{{ route('products.edit', $product->id) }}">Edit</a></th>
			<th>
				<form action="{{ route('products.destroy', $product->id) }}" method="POST">
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