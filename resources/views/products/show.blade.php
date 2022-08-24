@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2> Show product</h2>
		</div>
		<div class="pull-right">
			<a class="btn btn-primary" href="{{ route('products.index') }}"> Back </a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="form-group">
			<strong>Name:</strong>
			{{ $product->name }}
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="form-group">
			<strong>Category:</strong>
			{{ $category->name}}
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12">

		<strong>Image:</strong>
		<img src="/storage/{{ $product->image->full_image }}" class="img-fluid" alt="...">
		<!-- <img src="storage/{{ $product->image->preview_image }}" class="img-thumbnail" alt="{{ $product->name }}_image"> -->

	</div>

	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="form-group">
			<strong>Description:</strong>
			{{ $product->description }}
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="form-group">
			<strong>Price:</strong>
			{{ $product->price}}
		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="form-group">
			<strong>Created at:</strong>
			{{ $product->created_at}}
		</div>
	</div>
</div>

@endsection