@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Your Profile
@stop

<!-- <link href="{{URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"> -->
{{-- Account page content --}}
@section('account-content')
<div class="widget-container fluid-height clearfix container">
	<div class="page-header">
		<h4>Update your Profile</h4>
	</div>
	<form method="post" action="" class="form-vertical" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div class="clearfix"></div>

		<!-- Notifications -->
		@include('frontend/notifications')

           
      <div class="col-md-6">
		<div class="control-group">

			<!-- <div class="controls"> -->

			<div class="col-md-4">	
				<label class="control-label pull-left" for="first_name">First Name</label>
			</div>
			<div class="col-md-8">
				<input type="text" placeholder="Text" class="form-control{{ $errors->first('first_name', ' error') }}" name="first_name" id="first_name" value="{{ Input::old('first_name', $user->first_name) }}">
				{{ $errors->first('first_name', '<label class="error">:message</label>') }}
			</div>

			

		</div>
		<div class="clearfix"></div>
		@if(!($organization))
		<!-- Last Name -->
		<div class="control-group top-buffer">

			<div class="col-md-4">	
				<label class="control-label pull-left" for="last_name">Last Name</label>
			</div>	
			<div class="col-md-8">
				<input type="text" placeholder="Text" class="form-control{{ $errors->first('last_name', ' error') }}"  name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" >
				{{ $errors->first('last_name', '<label class="error">:message</label>') }}
			</div>
			<!-- <label class="control-label" for="last_name">Last Name</label> -->
			<!-- <div class="controls"> -->
<!-- <input class="span4" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" />
 {{ $errors->first('last_name', '<span class="error">:message</span>') }}
</div> -->
</div>
@endif


<div class="clearfix"></div>
<!-- Website URL -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="website">Website URL</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Text" class="form-control{{ $errors->first('website', ' error') }}" name="website" id="website" value="{{ Input::old('website', $user->website) }}" >
		{{ $errors->first('website', '<span class="error">:message</span>') }}
	</div>

	

</div>

<div class="clearfix"></div>
<!-- Organization -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="organization">Organization</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Text" class="form-control{{ $errors->first('organization', ' error') }}" name="organization" id="organization" value="{{ Input::old('organization', $user->organization) }}" >
		{{ $errors->first('organization', '<span class="error">:message</span>') }}
	</div>
	
</div>


<div class="clearfix"></div>
<!-- Position -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="position">Position</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Position" name="position" class="form-control{{ $errors->first('position', ' error') }}" value="{{ Input::old('position', $user->position) }}" >
		{{ $errors->first('position', '<label class="error">:message</label>') }}
	</div>

</div>

<div class="clearfix"></div>
<!-- Address1 -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="address1">Address</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Address1" name="address1" class="form-control{{ $errors->first('address1', ' error') }}" value="{{ Input::old('address1', $user->address1) }}" >
		{{ $errors->first('address1', '<label class="error">:message</label>') }}
	</div>

</div>

<div class="clearfix"></div>
<!-- Address2 -->
<div class="control-group top-buffer" style="display:none">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="address2">Address2</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Address2" name="address2" class="form-control{{ $errors->first('address2', ' error') }}" value="{{ Input::old('address2', $user->address2) }}" >
		{{ $errors->first('address1', '<label class="error">:message</label>') }}
	</div>
</div>

<div class="clearfix"></div>
<!-- City -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="city">City</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="City" name="city" class="form-control{{ $errors->first('city', ' error') }}" value="{{ Input::old('city', $user->city) }}" >
		{{ $errors->first('city', '<label class="error">:message</label>') }}
	</div>
	
</div>

<div class="clearfix"></div>
<!-- Zip -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="zip">Zip</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Zip" name="zip" class="form-control{{ $errors->first('zip', ' error') }}" value="{{ Input::old('zip', $user->zip) }}" >
		{{ $errors->first('zip', '<label class="error">:message</label>') }}
	</div>
</div>

<div class="clearfix"></div>
<!-- State -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="state">State</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="State" name="state" class="form-control{{ $errors->first('state', ' error') }}" value="{{ Input::old('state', $user->state) }}" >
		{{ $errors->first('state', '<label class="error">:message</label>') }}
	</div>
</div>

<div class="clearfix"></div>
<!-- Country -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left"  for="country">Country</label>
	</div>
	<div class="col-md-8">
		<input type="text"  placeholder="Text" class="form-control{{ $errors->first('country', ' error') }}" name="country" id="country" value="{{ Input::old('country', $user->country) }}" >
		{{ $errors->first('country', '<span class="error">:message</span>') }}
	</div>
</div>

<div class="clearfix"></div>
<!-- Phone -->
<div class="control-group top-buffer" style="display:none">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="phone">Phone</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Phone" name="phone" class="form-control{{ $errors->first('phone', ' error') }}" value="{{ Input::old('phone', $user->phone) }}" >
		{{ $errors->first('phone', '<label class="error">:message</label>') }}
	</div>
</div>

<div class="clearfix"></div>
<!-- Mobile -->
<div class="control-group top-buffer">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="mobile">Telephone</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Mobile" name="mobile" class="form-control{{ $errors->first('mobile', ' error') }}" value="{{ Input::old('mobile', $user->mobile) }}" >
		{{ $errors->first('mobile', '<label class="error">:message</label>') }}
	</div>
</div>

<div class="clearfix"></div>
<!-- Fax -->
<div class="control-group top-buffer" style="display:none">
	<div class="col-md-4">	
		<label class="control-label pull-left" for="fax">Fax</label>
	</div>
	<div class="col-md-8">
		<input type="text" placeholder="Fax" name="fax" class="form-control{{ $errors->first('fax', ' error') }}" value="{{ Input::old('fax', $user->fax) }}" >
		{{ $errors->first('fax', '<label class="error">:message</label>') }}
	</div>
</div>




<div class="clearfix"></div>
</div>
<div class="col-md-6">

	<div class="col-md-5">
		<select name="ddl_select_1" class="form-control">
			<option>Secondary</option>
			<option>bachelors</option>
			<option>masters</option>
			<option>doctorate</option>
			<option>other</option>
		</select>
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="col-md-4">
		<select name="field_of_study_1" class="form-control">
			<option>fields</option>
		</select>
	</div>
	<div class="col-md-4">
		<select name="topic_1" class="form-control">
			<option>topics</option>
		</select>
	</div>
	<div class="col-md-4">
		<input type="text" placeholder="Text" class="form-control" name="institution_1" value="Degree 1 Institution" >
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="col-md-4">
		<input type="text" placeholder="From"  name="from_1" class="datepicker form-control" data-date-autoclose="true" data-date-format="yyyy">
	</div>
	<div class="col-md-4">
		<input type="text" placeholder="To"  name="to_1" class="datepicker form-control" data-date-autoclose="true" data-date-format="yyyy">
	</div>
		<div class="clearfix"></div>
	<br>
	<div id="placeholderDiv">
	</div>
	<div class="col-md-12">
     <a href="#" class="btn btn-primary pull-right btn-add">add degree</a>
	</div>
</div>
<div class="clearfix"></div>

<hr>
<!-- Form actions -->
<div class="control-group">
	<div class="col-md-5">
		<div class="controls">

			<button type="submit" class="btn btn-primary">Update your Profile</button> 
			<!-- <button class="btn btn-success">Link with LinkedIn</button> -->
		</div>
	</div>
</div>

</form>
<div class="clearfix"></div>
<hr/>
</div>



@stop

