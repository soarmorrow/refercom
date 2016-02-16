@extends('frontend/layouts/layout')

@section('css')
<style type="text/css">
	.form-control{border-color:#66afe9;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6)}
    .container-fluid{background: #fff}
     .errorMsg{display: none;}.successMsg{display: none;}.container{background: white;}.confirm{position: absolute;margin: auto;top: 50%;right: 0;left: 0;bottom: 0;}
   a{
   	cursor: pointer;
   }
   a:hover{
        
        color: #007aff;  
   }
</style>
@stop

@section('js')
<script type="text/javascript">
	$(function(){

		$("input:text").focus(function() { $(this).select(); } );

		$('#btnDone').click(function(){
			var data = $("#skillform").serialize();
               data += '&job_form_id='+job_form_id;
    
      $.ajax({
      	url: baseUrl+'/ajax/skill-paste-done',
      	method:'post',
      	data: data,
      	success: function(data){
      		if(data.status=="success")
      		{
               
              var left = data.leftout;
                 var leftout ="";
                 var i=0;
             $.each(left, function(k, v) {
                if(i==0)
                    leftout += v;
                else
                	leftout += ','+v;

                i++;

              });

              $('.leftoutskills').text(leftout);

              $('#successDiv').show();
      		}
      		else
      		{
                
               $('.errorMsg').hide();
      			$('.errorMsg').html('<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Please make sure the correct skill codes are pasted before hitting Done !');
      			$('.errorMsg').show();



      		}
      	},
      	dataType: 'json'
        });
  });

	});

</script>
@stop

@section('content')
<body class="page-header-fixed bg-1">

  <!-- Navigation -->
   <div style="overflow: visible;" class="navbar navbar-fixed-top scroll-hide">
    <div class="container-fluid top-bar">
      <div class="pull-right">
  
          </div>
          <button class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="logo" href="index.html">se7en</a>
          <form class="navbar-form form-inline col-lg-2 hidden-xs">
            <input class="form-control" placeholder="Search" type="text">
          </form>
        </div>
    
      </div>
 
      		             <!-- Notifications -->
        @include('frontend/notifications')
      <!-- End Navigation -->
     <div class="container-fluid">
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
					<form id="skillform">
					<?php $i=1 ?>
					@foreach($fields as $field)
					@if($field->placeholder !=  '' || !empty($field->placeholder))
					
					<div class="row">
						<div class="col-md-7">
							<span style="color:black">&#9632; &nbsp; &nbsp; &nbsp;</span><span style="font-size:22px;color:black">{{ $field->label }}</span>
						</div>
						<div class="col-md-2">						
						<input type="text" class="form-control" name="{{'skill_'.$i}}" style="font-size:22px" value="{{ $field->placeholder }}"  />
						</div>
					</div>
					<?php $i++ ?>
					@endif
					@endforeach
					<input type="text" name="count" value="{{ $i }}" style="display:none">
                    <div class="clearfix"></div>
					<br>
 
					<input type="button" id="btnDone" class="btn btn-primary btn-lg pull-right" value="Done" />
				</form>
				<div class="clearfix"></div>
				<!-- Alert Boxes [success and Error]-->
				<div class="alert alert-success alert-dismissible successMsg" role="alert">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>success!</strong> saved
				</div>

				<div class="alert alert-danger alert-dismissible errorMsg" role="alert">
					<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<strong>Error!</strong> Failed!
				</div>
				<!-- /Alert Boxes [success and Error]-->
					<br>
					<br>
					<div id="successDiv" style="display:none">
					<p> Would you like to request recommendations on <span class="leftoutskills"></span> from former colleagues and supervisors?
						<ul>
						<li>Yes, I want to request them and then finish applying. <a href="{{ URL::route('new/form') }}">[Go to request]</a></li>
						<li> No, I am finished with the application. <a href="{{ route('skillcopysuccess',$form->unique_id) }}">[Continue]</a></li>
					    </ul>
					</p>	
					</div>
				</div>
			</div>
          
		</div>


	</div>
	</div>
</body>
<script type="text/javascript">
	var baseUrl = '{{ URL::to("/") }}';
	var job_form_id = '{{ $form->id }}';
</script>
@stop