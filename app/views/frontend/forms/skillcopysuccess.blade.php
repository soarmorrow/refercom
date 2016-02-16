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
   ul li{
   	list-style: none;
   }
</style>
@stop

@section('js')
<script type="text/javascript">
	$(function(){

		$("input:text").focus(function() { $(this).select(); } );

		$('#btnDone').click(function(){
			var data = $("#skillform").serialize();

    
      $.ajax({
      	url: baseUrl+'/ajax/skill-paste-done',
      	method:'post',
      	data: data,
      	success: function(data){
      		if(data.status=="success")
      		{
               
              var left = data.leftout;
                 var leftout ="";
                 var i=0
             $.each(left, function(k, v) {
                if(i==0)
                    leftout += v;
                else
                	leftout += ','+v;

                i++;

              });

              $('#successDiv span.leftoutskills').html(leftout);

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

	 <div class="clearfix"></div>
				 <br>
	<div class="container">

		<div class="col-lg-12">

			<div class="widget-container fluid-height clearfix" style="min-height:500px;">
				<div class="widget-content padded clearfix">
					<br>
					<div class="col-md-8">
					<h3>Thank you for applying for the <b>{{$form->name}}</b> position. The job application <b>deadline</b> is <b>{{$form->deadline}}</b>. We will be in touch with you soon regarding your application.go back to <a href="{{ route('signin')}}">dashboard</a>.</h3>
				    </div>
				    <div style="min-height:400px;background:wheat;" class="col-md-3 col-md-offset-1 text-center">
				       <div class="clearfix"></div>
                       <br>
				       <h4><b>Jobs applied for</b></h4>
				        <br>
				        <ul>
				        	@if(!is_null($applied_jobs))
				        	@foreach($applied_jobs as $job => $value)
                            <li style="font-size:15px">{{$job}}  ({{date("m/d/Y" , strtotime($value))}})</li>
				        	@endforeach
				        	@endif
				        </ul>

				    </div>
				</div>
			</div>
          
		</div>


	</div>
	</div>
</body>
<script type="text/javascript">
	var baseUrl = '{{ URL::to("/") }}';
</script>
@stop
