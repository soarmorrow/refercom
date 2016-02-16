@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Change your Email
@stop

{{-- Account page content --}}
@section('account-content')
<div class="widget-container fluid-height clearfix container">
<div class="page-header">
	<h4>Change your Email</h4>
</div>
<div class="clearfix"></div>

<!-- Notifications -->
			@include('frontend/notifications')

<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Form type -->
	<input type="hidden" name="formType" value="change-email" />

	<!-- New Email -->
	<div class="control-group top-buffer">
		<div class="col-md-3">
		<label class="control-label" for="email">New Email</label>
		</div>
		<div class="controls col-md-5">
			<input type="text" name="email" id="email" class="form-control{{ $errors->first('email', ' error') }}" value="" />
			{{ $errors->first('email', '<label class="error">:message</label>') }}
		</div>
	</div>
<div class="clearfix"></div>
	<!-- Confirm New Email -->
	<div class="control-group top-buffer">
		<div class="col-md-3">
		<label class="control-label" for="email_confirm">Confirm New Email</label>
		</div>
		<div class="controls col-md-5">
			<input type="text" name="email_confirm" id="email_confirm" class="form-control{{ $errors->first('email_confirm', ' error') }}"  value="" />
			{{ $errors->first('email_confirm', '<label class="error">:message</label>') }}
		</div>
	</div>
<div class="clearfix"></div>
	<!-- Current Password -->
	<div class="control-group top-buffer">
		<div class="col-md-3">
		<label class="control-label" for="current_password">Current Password</label>
		</div>
		<div class="controls col-md-5">
			<input type="password" name="current_password" id="current_password" class="form-control{{ $errors->first('current_password', ' error') }}" value="" />
			{{ $errors->first('current_password', '<label class="error">:message</label>') }}
		</div>
	</div>
<div class="clearfix"></div>
	<hr>

	<!-- Form actions -->
	<div class="control-group top-buffer">
		<div class="controls">
			<button type="submit" class="btn btn-primary">Update Email</button>

			<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
		</div>
	</div>
</form>
<div class="bottom-buffer"></div>
</div>
@stop
