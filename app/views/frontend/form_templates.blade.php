@extends('frontend/layouts/default')


{{-- Page content --}}
@section('content')
	<div class="row">

		<div class="widget-container fluid-height clearfix container">
		
			<div class="widget-content padded">

				<div class="page-header">
				<h4>Create New Form</h4>
				</div>
				<div class="clearfix"></div>

            	<!-- Notifications -->
				@include('frontend/notifications')

				<form class="form-horizontal" action="" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					
					<div class="form-group">
						<label class="control-label col-md-2">Name</label>
						<div class="col-md-7">
							<input type="text" placeholder="Text" name="name" class="form-control{{ $errors->first('name', ' error') }}">
						{{ $errors->first('name', '<label class="error">:message</label>') }}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Description</label>
						<div class="col-md-7">
							<textarea rows="3" name="description" class="form-control{{ $errors->first('name', ' error') }}"></textarea>
								{{ $errors->first('description', '<label class="error">:message</label>') }}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Status</label>
						<div class="col-md-7">
							<select class="form-control{{ $errors->first('name', ' error') }}" name="status"><option value="1">Yes</option><option value="0">No</option></select>
						{{ $errors->first('status', '<label class="error">:message</label>') }}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">tabbed</label>
						<div class="col-md-7">
							<label class="radio-inline"><input type="radio" value="option1" name="tabbed" value="0"><span>yes</span></label>
							<label class="radio-inline"><input type="radio" value="option2" name="tabbed" value="1" checked=""><span>no</span></label>
						{{ $errors->first('tabbed', '<label class="error">:message</label>') }}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Type</label>
						<div class="col-md-7">
							<select class="form-control{{ $errors->first('name', ' error') }}" name="type"><option value="Category 1">Option 1</option><option value="Category 2">Option 2</option><option value="Category 3">Option 3</option><option value="Category 4">Option 4</option></select>
						{{ $errors->first('type', '<label class="error">:message</label>') }}
						</div>
					</div>
					<div class="form-group">
					
						<div class="col-md-7 margin200">
							<button type="submit" class="btn btn-primary">Submit</button><button class="btn btn-default-outline">Cancel            </button>
						</div>
					</div>
				</form>
     		</div>
			<div class="clearfix"></div>
		</div>	
	</div>

@stop