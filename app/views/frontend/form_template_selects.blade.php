@extends('frontend/layouts/default')


{{-- Page content --}}
@section('content')
<!-- <div class="row">
	<div class="span3">
		<ul class="nav nav-list">
			<li class="nav-header">Main Menu</li>
			<li{{ Request::is('account/profile') ? ' class="active"' : '' }}><a href="{{ URL::route('profile') }}">Profile</a></li>
			<li{{ Request::is('account/change-password') ? ' class="active"' : '' }}><a href="{{ URL::route('change-password') }}">Change Password</a></li>
			<li{{ Request::is('account/change-email') ? ' class="active"' : '' }}><a href="{{ URL::route('change-email') }}">Change Email</a></li>
		</ul>
	</div> -->
	<div class="span9">
		<div class="widget-container fluid-height clearfix container">
			<div class="clearfix"></div>
			<div class="widget-content padded">
				<form class="form-horizontal" action="#">
					
					
					<div class="form-group">
						<label class="control-label col-md-2">Value</label>
						<div class="col-md-7">
							<select class="form-control"><option value="Category 1">Option 1</option><option value="Category 2">Option 2</option><option value="Category 3">Option 3</option><option value="Category 4">Option 4</option></select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">option</label>
						<div class="col-md-7">
							<select class="form-control"><option value="Category 1">Option 1</option><option value="Category 2">Option 2</option><option value="Category 3">Option 3</option><option value="Category 4">Option 4</option></select>
						</div>
					</div>
					
				</form>
     		</div>
			<div class="clearfix"></div>
		</div>	
	</div>

@stop