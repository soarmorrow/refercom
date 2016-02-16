@extends('frontend/layouts/default')
@section('css')
<link href="{{URL::asset('assets/stylesheets/datepicker.css')}}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('js')
<script src="{{URL::asset('assets/javascripts/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/js/form.js')}}"></script>
@stop

@section('content')
<?php 
$Session = Session::get('letter_type');
?>
<script type="text/javascript">
	var letter_type="";
	<?php if(isset($Session)){
		?>
		letter_type = <?php echo json_encode(Session::get('letter_type'));  
	}else {  ?>

		letter_type="";

		<?php }  ?>
</script>

<div class="row">
	<div class="widget-container fluid-height clearfix container">
		
		<div class="widget-content padded">

			<div class="page-header">
				<h4>Send Form</h4> 
			</div>
			<div class="clearfix"></div>

			<!-- Notifications -->
			@include('frontend/notifications')

			<form class="form-horizontal" action="" method="post">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-group">
						<label class="control-label col-md-2">Letter/form Type</label>
						<div class="col-md-8">
							<select name="form_type" class="form-control" id="type">
								<option value="">Select a letter type</option>
								<option value="Academic" <?php if(Session::get('letter_type') != null){ if(Session::get('letter_type') == 'Academic'){ echo 'selected';} }else{echo '';}?> >Academic</option>
								<option value="Professional" <?php if(Session::get('letter_type') != null){ if(Session::get('letter_type') == 'Professional'){ echo 'selected';} }else{echo '';}?> >Professional</option>
								<option value="Personal">Personal</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>
                    

					<div class="form-group">
						<label class="control-label col-md-2">Relationship</label>
						<div class="col-md-8" id="relationship">
							<select name="relationship" class="form-control"><option value="">Select a letter type first</select>
						</div>
					</div>
					    <?php if(Session::get('letter_type') == 'Professional' || Session::get('letter_type') == 'Academic' ){  ?>
					  
					    	<script type="text/javascript">
					    	       if(letter_type == 'Professional')
					    			var val = 'Professional';
					    		   else
					    		   	var val = 'Academic'
                                    
                                    
					    			var html = '';
					    			if(val == 'Academic')
					    				html = '<select name="relationship" class="form-control"><option value="professor" selected >Professor</option><option value="staff">Staff</option></select>';
					    			else if	( val == 'Professional')
					    				html = '<select name="relationship" class="form-control"><option value="supervisor">supervisor</option><option value="colleague">colleague</option><option value="mentor">mentor</option></select>';
					    			else if(val == 'Personal')	
					    				html = '<select name="relationship" class="form-control"><option value="friend">friend</option><option value="acquaintance">acquaintance</option></select>';
					    			else 	
					    				html = '<input type="text" placeholder="Relationship" name="relationship" class="form-control{{ $errors->first('relationship', ' error') }}">';
					    			$('#relationship').html(html);
					    	
                            </script>
						
						<?php } ?>
				
					<script type="text/javascript">
				
					$(function(){
					$('#type').on('change' , function(){
					
						var val = $(this).val();
						var profselected='';
						var acaselected='';

						if(letter_type != null){ 
							if(letter_type == "Professional"){
								profselected = 'selected';
							}
							else if(letter_type == "Academic")
							{
							   acaselected = 'selected';	
							} 
			         	}
						var html = '';
						if(val == 'Academic')
							html = '<select name="relationship" class="form-control"><option value="professor" '+acaselected+' >Professor</option><option value="staff">Staff</option></select>';
						else if	( val == 'Professional')
							html = '<select name="relationship" class="form-control"><option value="supervisor" '+profselected+' >supervisor</option><option value="colleague">colleague</option><option value="mentor">mentor</option></select>';
						else if(val == 'Personal')	
							html = '<select name="relationship" class="form-control"><option value="friend">friend</option><option value="acquaintance">acquaintance</option></select>';
						else 	
							html = '<input type="text" placeholder="Relationship" name="relationship" class="form-control{{ $errors->first('relationship', ' error') }}">';
						$('#relationship').html(html);
					});
                    });
					</script>

                  



				<div class="form-group">
					<label class="control-label col-md-2">Deadline</label>
					<div class="col-md-4">
						<div class="input-group date datepicker" data-date-format="mm-dd-yyyy">
							<input class="form-control" type="text" name="deadline" value="{{ Input::old('deadline') }}"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div>
					{{ $errors->first('deadline', '<label class="error">:message</label>') }}
				</div>

				

				@if($user->organization)
					<h3>Seeker Details</h3>
				@else
					<h3>Your Details</h3>
				@endif

				<div class="form-group">
					
					<div class="col-md-4 col-md-offset-1">
						<input type="text" placeholder="First Name" name="seeker_first_name" class="form-control{{ $errors->first('seeker_first_name', ' error') }}" value="{{Sentry::getUser()->first_name}}">
						{{ $errors->first('first_name', '<label class="error">:message</label>') }}
					</div>
			
				
					<div class="col-md-4 col-md-offset-1">
						<input type="text" placeholder="Last Name" name="seeker_last_name" class="form-control{{ $errors->first('seeker_last_name', ' error') }}" value="{{Sentry::getUser()->last_name}}">
						{{ $errors->first('last_name', '<label class="error">:message</label>') }}
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Organisation" name="seeker_organisation" class="form-control{{ $errors->first('seeker_organisation', ' error') }}" value="{{Sentry::getUser()->organization}}">
						{{ $errors->first('organisation', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
				
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Position" name="seeker_position" class="form-control{{ $errors->first('seeker_position', ' error') }}" value="{{Sentry::getUser()->position}}">
						{{ $errors->first('position', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Email" name="seeker_email" class="form-control{{ $errors->first('seeker_seeker_email', ' error') }}"  value="{{Sentry::getUser()->email}}">
						{{ $errors->first('seeker_email', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
			
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Address" name="seeker_address1" class="form-control{{ $errors->first('seeker_address1', ' error') }}" value="{{Sentry::getUser()->address1}}">
						{{ $errors->first('address1', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
				
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="address2" name="seeker_address2" class="form-control{{ $errors->first('seeker_address2', ' error') }}" value="{{Sentry::getUser()->address2}}">
						{{ $errors->first('address2', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
					
					<div class="col-md-3 col-md-offset-1">
						<input type="text" placeholder="City" name="seeker_address3" class="form-control{{ $errors->first('seeker_address3', ' error') }}" value="{{Sentry::getUser()->city}}">
						{{ $errors->first('address3', '<label class="error">:message</label>') }}
					</div>
					
					<div class="col-md-3">
						<input type="text" placeholder="Zip" name="seeker_zip" class="form-control{{ $errors->first('seeker_zip', ' error') }}" value="{{Sentry::getUser()->zip}}">
						{{ $errors->first('zip', '<label class="error">:message</label>') }}
					</div>
			
					<div class="col-md-3">
						<input type="text" placeholder="State" name="seeker_state" class="form-control{{ $errors->first('seeker_state', ' error') }}" value="{{Sentry::getUser()->state}}">
						{{ $errors->first('state', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
				
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Country" name="seeker_country" class="form-control{{ $errors->first('seeker_country', ' error') }}" value="{{Sentry::getUser()->country}}" >
						{{ $errors->first('country', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="phone" name="seeker_phone" class="form-control{{ $errors->first('seeker_phone', ' error') }}" value="{{Sentry::getUser()->phone}}">
						{{ $errors->first('phone', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
		
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Telephone" name="seeker_mobile" class="form-control{{ $errors->first('seeker_mobile', ' error') }}" value="{{Sentry::getUser()->mobile}}" >
						{{ $errors->first('mobile', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
				
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="fax" name="seeker_fax" class="form-control{{ $errors->first('seeker_fax', ' error') }}" value="{{Sentry::getUser()->fax}}">
						{{ $errors->first('fax', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
				
					<div class="col-md-9 col-md-offset-1">
					<a class="btn btn-small btn-primary face" title="facebook"><i class="fa fa-facebook"></i></a>
					<a class="btn btn-small btn-primary twit" title="twitter"><i class="fa fa-twitter"></i></a>
					<a class="btn btn-small btn-primary linked" title="linkedin"><i class="fa fa-linkedin"></i></a>
					<a class="btn btn-small btn-primary goog" title="google"><i class="fa fa-google-plus"></i></a>
					<a class="btn btn-small btn-primary git" title="github"><i class="fa fa-github"></i></a>
					<a class="btn btn-small btn-primary scholar" title="google-scholar"><i class="fa fa-google-plus-square"></i></a>
				    </div>
				</div>
				<div class="form-group fb" style="display:none;">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="facebook" name="seeker_facebook" class="form-control{{ $errors->first('seeker_facebook', ' error') }}">
						{{ $errors->first('facebook', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group tw" style="display:none;">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="twitter" name="seeker_twitter" class="form-control{{ $errors->first('seeker_twitter', ' error') }}">
						{{ $errors->first('twitter', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group ln" style="display:none;">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="linkedin" name="seeker_linkedin" class="form-control{{ $errors->first('seeker_linkedin', ' error') }}">
						{{ $errors->first('linkedin', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group go" style="display:none;">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="google" name="seeker_google" class="form-control{{ $errors->first('seeker_google', ' error') }}">
						{{ $errors->first('google', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group gs" style="display:none;">
			
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="google_scholar" name="seeker_google_scholar" class="form-control{{ $errors->first('seeker_google_scholar', ' error') }}">
						{{ $errors->first('google_scholar', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group ghub" style="display:none;">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="github" name="seeker_github" class="form-control{{ $errors->first('seeker_github', ' error') }}">
						{{ $errors->first('github', '<label class="error">:message</label>') }}
					</div>
				</div>

				
				<h3>Writer Information</h3>
			
				<div class="form-group">
				
					<div class="col-md-offset-1 col-md-9">
						<input type="text" placeholder="Writer Email" name="writer_email" class="form-control{{ $errors->first('writer_email', ' error') }}">
						{{ $errors->first('writer_email', '<label class="error">:message</label>') }}
					</div>
				</div>
				
				<div class="form-group">
					
					<div class="col-md-offset-1 col-md-4">
						<input type="text" placeholder="First Name" name="first_name" class="form-control{{ $errors->first('first_name', ' error') }}">
						{{ $errors->first('first_name', '<label class="error">:message</label>') }}
					</div>

					
				
					<div class="col-md-4 col-md-offset-1">
						<input type="text" placeholder="Last Name" name="last_name" class="form-control{{ $errors->first('last_name', ' error') }}">
						{{ $errors->first('last_name', '<label class="error">:message</label>') }}
					</div>

				</div>




				<div class="form-group">
					
					<div class="col-md-offset-1 col-md-9">
						<input type="text" placeholder="Organisation" name="organisation" class="form-control{{ $errors->first('organisation', ' error') }}" value="<?php echo Session::get('company');  ?>" >
						{{ $errors->first('organisation', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
					
					<div class="col-md-offset-1 col-md-9">
						<input type="text" placeholder="Position" name="position" class="form-control{{ $errors->first('position', ' error') }}">
						{{ $errors->first('position', '<label class="error">:message</label>') }}
					</div>
				</div>
				
				<div class="form-group">
					
					<div class="col-md-offset-1 col-md-9">
						<input type="text" placeholder="Address" name="address1" class="form-control{{ $errors->first('address1', ' error') }}">
						{{ $errors->first('address1', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					
					<div class="col-md-offset-1 col-md-9">
						<input type="text" placeholder="address2" name="address2" class="form-control{{ $errors->first('address2', ' error') }}">
						{{ $errors->first('address2', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
					
					<div class="col-md-offset-1 col-md-3">
						<input type="text" placeholder="city" name="address3" class="form-control{{ $errors->first('address3', ' error') }}">
						{{ $errors->first('address3', '<label class="error">:message</label>') }}
					</div>

					
					<div class="col-md-3">
						<input type="text" placeholder="Zip" name="zip" class="form-control{{ $errors->first('zip', ' error') }}">
						{{ $errors->first('zip', '<label class="error">:message</label>') }}
					</div>
					
			
					<div class="col-md-3">
						<input type="text" placeholder="State" name="state" class="form-control{{ $errors->first('state', ' error') }}">
						{{ $errors->first('state', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
				
					<div class="col-md-offset-1 col-md-9">
						<input type="text" placeholder="Country" name="country" class="form-control{{ $errors->first('country', ' error') }}">
						{{ $errors->first('country', '<label class="error">:message</label>') }}
					</div>
				</div>

				<div class="form-group" style="display:none" >
					<label class="control-label col-md-2">phone</label>
					<div class="col-md-9">
						<input type="text" placeholder="phone" name="phone" class="form-control{{ $errors->first('phone', ' error') }}">
						{{ $errors->first('phone', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
		
					<div class="col-md-offset-1 col-md-9">
						<input type="text" placeholder="Telephone" name="mobile" class="form-control{{ $errors->first('mobile', ' error') }}">
						{{ $errors->first('mobile', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					<div class="col-md-offset-1 col-md-9">
						<input type="text" placeholder="fax" name="fax" class="form-control{{ $errors->first('fax', ' error') }}">
						{{ $errors->first('fax', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					<label class="control-label col-md-2">facebook</label>
					<div class="col-md-9">
						<input type="text" placeholder="facebook" name="facebook" class="form-control{{ $errors->first('facebook', ' error') }}">
						{{ $errors->first('facebook', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					<label class="control-label col-md-2">twitter</label>
					<div class="col-md-9">
						<input type="text" placeholder="twitter" name="twitter" class="form-control{{ $errors->first('twitter', ' error') }}">
						{{ $errors->first('twitter', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					<label class="control-label col-md-2">linkedin</label>
					<div class="col-md-9">
						<input type="text" placeholder="linkedin" name="linkedin" class="form-control{{ $errors->first('linkedin', ' error') }}">
						{{ $errors->first('linkedin', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					<label class="control-label col-md-2">google</label>
					<div class="col-md-9">
						<input type="text" placeholder="google" name="google" class="form-control{{ $errors->first('google', ' error') }}">
						{{ $errors->first('google', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					<label class="control-label col-md-2">google_scholar</label>
					<div class="col-md-9">
						<input type="text" placeholder="google_scholar" name="google_scholar" class="form-control{{ $errors->first('google_scholar', ' error') }}">
						{{ $errors->first('google_scholar', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					<label class="control-label col-md-2">github</label>
					<div class="col-md-9">
						<input type="text" placeholder="github" name="github" class="form-control{{ $errors->first('github', ' error') }}">
						{{ $errors->first('github', '<label class="error">:message</label>') }}
					</div>
				</div>
               <div>
               </div>
				<div class="col-md-9 text-center">
				<a href="" id="addskill" data-id="1" class="btn btn-primary addskill">add skill</a>
				</div>
				<div class="clearfix"></div>

				<div class="new-writer-div">
					
				</div>
				
                <div class="col-md-3">

                	<a href="" id="addwriter" class="btn btn-info">add another writer</a>
                	<input type="hidden" id="hdnWriterCount" name="writer_count" value="" />
                	
                </div>
                <div class="clearfix"></div>
				<h3>Recipient Information</h3>
				
				<div class="form-group">
			
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="First Name" name="first_name_r_0" class="form-control{{ $errors->first('first_name_r_0', ' error') }}">
						{{ $errors->first('first_name_r_0', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
				
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Last Name" name="last_name_r_0" class="form-control{{ $errors->first('last_name_r_0', ' error') }}">
						{{ $errors->first('last_name_r_0', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Organisation" name="organisation_r_0" class="form-control{{ $errors->first('organisation_r_0', ' error') }}">
						{{ $errors->first('organisation_r_0', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
				
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Position" name="position_r_0" class="form-control{{ $errors->first('position_r_0', ' error') }}">
						{{ $errors->first('position_r', '<label class="error">:message</label>') }}
					</div>
				</div>
				
				<div class="form-group">
			
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Address" name="address1_r_0" class="form-control{{ $errors->first('address1_r_0', ' error') }}">
						{{ $errors->first('address1_r', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group" style="display:none">
					
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="address2" name="address2_r_0" class="form-control{{ $errors->first('address2_r_0', ' error') }}">
						{{ $errors->first('address2_r', '<label class="error">:message</label>') }}
					</div>
				</div>
				
				<div class="form-group">
				
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Zip" name="zip_r_0" class="form-control{{ $errors->first('zip_r_0', ' error') }}">
						{{ $errors->first('zip_r', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="form-group">
				
					<div class="col-md-9 col-md-offset-1">
						<input type="text" placeholder="Email" name="recipient_email_0" class="form-control{{ $errors->first('recipient_email_0', ' error') }}" value="{{ $user->email}}">
						{{ $errors->first('recipient_email', '<label class="error">:message</label>') }}
					</div>
				</div>
				<div class="new-recpt-div">
					
				</div>
				<div class="col-md-3">
					<a href="" id="addrecepient" class="btn btn-info">add another recepient</a>
					<input type="hidden" id="hdnRecptCount" name="r_count" value="" />
				</div>

			</div>
			<div class="form-group">

				<div class="col-md-9 margin200">
					<button type="submit" class="btn btn-primary">Submit</button><button class="btn btn-default-outline">Cancel</button>

				</div>

				<div class="clearfix"></div>
				<br/>
			</div>
		</form>
	</div>

	<div class="clearfix"></div>

</div>	

@stop