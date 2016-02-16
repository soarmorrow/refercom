@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Create a Form Template ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Create a Form Template

		<div class="pull-right">
			<a href="{{ route('users') }}" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- First Name -->
	<div class="control-group {{ $errors->has('first_name') ? 'error' : '' }}">
	<label class="control-label" for="Name">Name</label>
		<div class="controls">
			<input type="text" name="name" id="name" value="{{ Input::old('name') }}" />
			{{ $errors->first('Name', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Last Name -->
	<div class="control-group {{ $errors->has('Description') ? 'error' : '' }}">
		<label class="control-label" for="description">Description</label>
		<div class="controls">
			<input type="text" name="description" id="description" value="{{ Input::old('Description') }}" />
			{{ $errors->first('Description', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Status -->
	<div class="control-group {{ $errors->has('Status') ? 'error' : '' }}">
		<label class="control-label" for="status">Status</label>
		<div class="controls">
		<select class="form-control" name="status" id="status"><option value="enabled">Enabled</option><option value="disabled">Disabled</option></select>
			<!-- <input type="text" name="Status" id="Status" value="{{ Input::old('Status') }}" /> -->
		<!-- 	{{ $errors->first('email', '<span class="help-inline">:message</span>') }} -->
		</div>
	</div>

	<div class="control-group {{ $errors->has('Tabbed') ? 'error' : '' }}">
		<label class="control-label" for="tabbed">Tabbed</label>
		<div class="controls">
			<select class="form-control" name="tabbed" id="tabbed"><option value="1">Yes</option><option value="0">No</option></select>
			<!-- <input type="text" name="Status" id="Status" value="{{ Input::old('Status') }}" /> -->
			<!-- 	{{ $errors->first('email', '<span class="help-inline">:message</span>') }} -->
		</div>
	</div>
.   
    <div class="control-group {{ $errors->has('Type') ? 'error' : '' }}">
		<label class="control-label" for="type">Type</label>
		<div class="controls">
			<select class="form-control"><option value="Category 1">Option 1</option><option value="Category 2">Option 2</option><option value="Category 3">Option 3</option><option value="Category 4">Option 4</option></select>
			<!-- <input type="text" name="Status" id="Status" value="{{ Input::old('Status') }}" /> -->
			<!-- 	{{ $errors->first('email', '<span class="help-inline">:message</span>') }} -->
		</div>
	</div>
	<hr/>
	<!-- Form Actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn btn-default" href="{{ route('form-templates') }}">Cancel</a>

		

			<button type="submit" class="btn btn-success">Submit</button>
		</div>
	</div>

	</form>
@stop
