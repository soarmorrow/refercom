@extends('frontend/layouts/default')

@section('css')
<link href="{{URL::asset('assets/stylesheets/datepicker.css')}}" media="all" rel="stylesheet" type="text/css" />
<style type="text/css">
	.form-control{border-color:#66afe9;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6)}

</style>
@stop

@section('js')
<script type="text/javascript">
	$(function(){
         
         $("input:text").focus(function() { $(this).select(); } );
	});
</script>
<script src="{{URL::asset('assets/javascripts/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){

		$('.datepicker').datepicker({
		});
           var i= $('#hdnCount').val();
		$('#btnaddanother').click(function(){
             
             $('#anotherDiv').append('<div class="form-group"><label class="control-label col-md-3">Skill name:</label><div class="col-md-7"><input type="text" placeholder="Skill name" name="skill_'+i+'" class="form-control" value=""></div></div><div class="clearfix"></div><br><div class="form-group"><label class="control-label col-md-3">Text Description:</label><div class="col-md-7"><input type="text" placeholder="Description" name="desc_'+i+'" class="form-control" value=""></div></div><div class="clearfix"></div><br>');
              
             $('#hdnCount').val(i); 
				i++;
		});
	});
</script>
@stop

@section('content')

     <div class="container-fluid">
              <!-- Notifications -->
        @include('frontend/notifications')
    <div class="container">
      		<div class="widget-container fluid-height clearfix">
				<div class="widget-content padded clearfix">
				 <br>
				  <h2>Finalized form (<strong>code:</strong><code> {{ $form->unique_id }}</code>)</h2>
				 <div class="clearfix"></div>
				 <br>
				 <?php $embedUrl = route("embedform",$form->unique_id);  ?>
				 <input id="embedInput" type="text" class="form-control" value='<iframe frameborder="0" width="100%" height="500" src="{{$embedUrl}}"><p>iframes are not supported by your browser.</p></iframe>' />
				 
				

                  <div class="clearfix"></div>
				  <br>
				</div>
			</div>
    </div>
	 <div class="clearfix"></div>
				 <br>
	<div class="container">

		<div class="col-lg-12">

			<div class="widget-container fluid-height clearfix" style="min-height:500px;">
				<div class="widget-content padded clearfix">
					<br>
					<form id="form_ind" method="get" action="{{ route('postskills',$form->id)}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label class="control-label col-md-3">Deadline</label>
					<div class="col-md-7">
						<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="mm-dd-yyyy">
						<input class="form-control" type="text" name="deadline" value="{{$form->deadline}}" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="form-group">
					<label class="control-label col-md-3">Title:</label>
					<div class="col-md-7">
						<input type="text" placeholder="Title"  name="form_name" class="form-control" value="{{ $form->name }}">
					</div>
				</div>
				<?php $i=1 ?>
				@foreach($fields as $field)
				<div class="clearfix"></div>
				<br>
				<div class="form-group">
					<label class="control-label col-md-3">Skill name:</label>
					<div class="col-md-7">
						<input type="text" placeholder="Skill name"  name="{{'skill_'.$i}}" class="form-control" value="{{ $field->placeholder }}">
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="form-group">
					<label class="control-label col-md-3">Text Description:</label>
					<div class="col-md-7">
						<input type="text" placeholder="Description" name="{{'desc_'.$i}}" class="form-control" value="{{$field->label}}">
					</div>
				</div>
				<?php $i++ ?>
				@endforeach
				<input type="text" value="{{ $i }}" name="count" id="hdnCount" style="display:none"/>
				<div class="clearfix"></div>
				<br>
				<div id="anotherDiv">
					
				</div>
				<div class="col-md-10">
                 <input type="submit" class="btn btn-primary pull-right" value="Done" />
                 <a href="#" id="btnaddanother" class="btn btn-primary pull-right">Add another </a>
				</div>
			</form>
                    
				</div>
				<div class="clearfix"></div>
				<br>
				
			</div>
			
		</div>

		<div>
			

		</div>

	</div>
	</div>

@stop