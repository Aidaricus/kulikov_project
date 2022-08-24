@extends('layouts.app')
@section('content')

<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2>Create new product</h2>
		</div>
		<div class="pull-right">
			<a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
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

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
	@csrf

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Name:</strong>
				<input type="text" name="name" class="form-control" placeholder="name" value="{{ old('name') }}">
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<strong>Category:</strong>
			<select class="form-select" name="category_id" id="category" aria-label="Default select example">
				<!-- <option value= selected>Выбрать категорию</option> -->
				@foreach($categories as $category)
				<option value="{{$category->id}}" name="category_id">{{$category->name}}</option>
				@endforeach
			</select>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Description:</strong>
				<textarea type="text" name="description" class="form-control" placeholder="description" value="{{ old('description') }}"></textarea>
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Price:</strong>
				<input type="integer" name="price" class="form-control" placeholder="$">
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<strong>Choose image:</strong>
			<div class="input-group mb-3">

				<input type="file" class="form-control" id="image" name="image" id="inputGroupFile02">
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="btn btn-outline-success">Submit</button>
		</div>
	</div>
</form>
@endsection