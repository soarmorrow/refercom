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
						<label class="control-label col-md-2">Name</label>
						<div class="col-md-7">
							<input type="text" placeholder="Text" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Table Name</label>
						<div class="col-md-7">
							<input type="text" placeholder="Text" class="form-control">
						</div>
					</div>
				
					<div class="form-group">
						<label class="control-label col-md-2">Form Actions</label>
						<div class="col-md-7 offset1">
							<button type="submit" class="btn btn-primary">Submit</button><button class="btn btn-default-outline">Cancel            </button>
						</div>
					</div>
				</form>
     		</div>
			<div class="clearfix"></div>
		</div>	
	</div>

@stop