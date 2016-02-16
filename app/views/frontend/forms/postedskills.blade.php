@extends('frontend/layouts/default')

@section('css')
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
					<strong style="font-size:24px;color:black">{{$form->name}}</strong>
					<div class="clearfix"></div>
					<br>
					@foreach($fields as $field)
					@if($field->placeholder !=  '' || !empty($field->placeholder))
					
					<div class="row">
						<div class="col-md-9">
							<span style="color:black">&#9632; &nbsp; &nbsp; &nbsp;</span><span style="font-size:22px;color:black">{{ $field->label }}</span>
						</div>
						<div class="col-md-2">						
						<input type="text" class="form-control" style="font-size:22px" value="{{ $field->placeholder }}"  />
						</div>
					</div>
					@endif
					@endforeach
                    
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="container padded">
				 <a href="{{ route('edit-posted-skills',$form->id)}}" class="btn btn-success btn-lg"> Edit </a> <a href="{{ route('publish',$form->id)}}" class="btn btn-success btn-lg"> Publish </a>
			    </div>
			</div>
			
		</div>

		<div>
			

		</div>

	</div>
	</div>

@stop