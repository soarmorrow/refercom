@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Change your Password
@stop

{{-- Account page content --}}
@section('account-content')
<div class="widget-container fluid-height clearfix container">
<div class="page-header">
	<h4>Change your Password</h4>
</div>

<!-- Notifications -->
			@include('frontend/notifications')
<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Old Password -->
	<div class="control-group ">
		<div class="col-md-3">
		<label class="control-label" for="old_password">Old Password</label>
	    </div>
		<div class="controls col-md-5">
			<input type="password" name="old_password" id="old_password" class="form-control{{ $errors->first('old_password', ' error') }}"  value="" />
			{{ $errors->first('old_password', '<label class="error">:message</label>') }}
		</div>
	</div>

<div class="clearfix"></div>
	
	<!-- New Password -->
	<div class="control-group top-buffer">
		<div class="col-md-3">
		<label class="control-label" for="password">New Password</label>
	    </div>
		<div class="controls col-md-5">
			<input type="password" name="password" id="password" class="form-control{{ $errors->first('password', ' error') }}"  value="" />
			{{ $errors->first('password', '<label class="error">:message</label>') }}
		</div>
	</div>

<div class="clearfix"></div>

	<!-- Confirm New Password  -->
	<div class="control-group top-buffer">
		<div class="col-md-3">
		<label class="control-label" for="password_confirm">Confirm New Password</label>
	    </div>
		<div class="controls col-md-5">
			<input type="password" name="password_confirm" id="password_confirm" class="form-control{{ $errors->first('password_confirm', ' error') }}"  value="" />
			{{ $errors->first('password_confirm', '<label class="error">:message</label>') }}
		</div>
	</div>

<div class="clearfix"></div>

	<hr>

	<!-- Form actions -->
	<div class="control-group top-buffer">
		<div class="controls">
			<button type="submit" class="btn btn-primary">Update Password</button>

			<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
		</div>
	</div>
</form>
<div class="bottom-buffer"></div>
</div>
@stop

