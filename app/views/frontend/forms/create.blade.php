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
							<textarea rows="3" name="description" class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Tabbed</label>
						<div class="col-md-7">
							<label class="radio-inline"><input type="radio" name="tabbed" value="1"><span>Yes</span></label>
							<label class="radio-inline"><input type="radio" name="tabbed" value="0" checked=""><span>No</span></label>
							{{ $errors->first('tabbed', '<label class="error">:message</label>') }}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">Type</label>
						<div class="col-md-7">
							<input type="text" class="form-control{{ $errors->first('type', ' error') }}" name="type" />
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