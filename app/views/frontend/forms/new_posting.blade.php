@extends('frontend/layouts/default')

@section('css')
<link href="{{URL::asset('assets/stylesheets/bootstrap-select.css')}}" media="all" rel="stylesheet" type="text/css" />
<style type="text/css">
	.errorMsg{display: none;}.successMsg{display: none;}.container{background: white;}.confirm{position: absolute;margin: auto;top: 50%;right: 0;left: 0;bottom: 0;}
	::selection {
		background: #ffb7b7 !important; /* WebKit/Blink Browsers */
	}
	::-moz-selection {
		background: #ffb7b7 !important; /* Gecko Browsers */
	}
</style>


<link href="{{URL::asset('assets/stylesheets/datepicker.css')}}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('js')

<script src="{{URL::asset('assets/javascripts/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){

		$('.datepicker').datepicker({
		});
           var i=2;
		$('#btnaddanother').click(function(){
             
             $('#anotherDiv').append('<div class="form-group"><label class="control-label col-md-3">Skill name:</label><div class="col-md-7"><input type="text" placeholder="Skill name" name="skill_'+i+'" class="form-control" value=""></div></div><div class="clearfix"></div><br><div class="form-group"><label class="control-label col-md-3">Text Description:</label><div class="col-md-7"><input type="text" placeholder="Description" name="desc_'+i+'" class="form-control" value=""></div></div><div class="clearfix"></div><br>');
              
             $('#hdnCount').val(i); 
				i++;
		});

		$('#btnget').click(function(){
            var k=1;
			var lines = $('textarea').val().split('\n');
			for(var i = 0;i < lines.length;i++){
                if( lines[i].trim() === "" )
                {

                }
                else
                {
				 console.log(lines[i]);
			     if(k==1)
                 $('.multidiv').html('<div class="clearfix"></div><br><div class="form-group"><label class="control-label col-md-3">Skill name:</label><div class="col-md-7"><input type="text" placeholder="Skill name" name="skill_'+k+'" class="form-control" value=""></div></div><div class="clearfix"></div><br><div class="form-group"><label class="control-label col-md-3">Text Description:</label><div class="col-md-7"><input type="text" placeholder="Description" name="desc_'+k+'" class="form-control" value="'+lines[i]+'"></div></div><div class="clearfix"></div><br>');
                else
                 $('.multidiv').append('<div class="form-group"><label class="control-label col-md-3">Skill name:</label><div class="col-md-7"><input type="text" placeholder="Skill name" name="skill_'+k+'" class="form-control" value=""></div></div><div class="clearfix"></div><br><div class="form-group"><label class="control-label col-md-3">Text Description:</label><div class="col-md-7"><input type="text" placeholder="Description" name="desc_'+k+'" class="form-control" value="'+lines[i]+'"></div></div><div class="clearfix"></div><br>');
                  
                 $('#hdnCount2').val(k); 
                 k++;

     
                }

			}
		});
	});
</script>
@stop

@section('content')
<div class="container padded">
              <!-- Notifications -->
        @include('frontend/notifications')
	<div class="col-md-12" style="background-color:white;">

		<div class="clearfix"></div>
		<br>
		<div class="col-md-6">
			<div class="text-center">
				<span style="font-size:20px;color:red">Individually adding skill forms</span>
			</div>
			<div class="clearfix"></div>
			<br>
			<form id="form_ind" method="get" action="{{ route('postskills',$form->id)}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label class="control-label col-md-3">Deadline</label>
					<div class="col-md-7">
						<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="mm-dd-yyyy">
						<input class="form-control" type="text" name="deadline" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="form-group">
					<label class="control-label col-md-3">Title:</label>
					<div class="col-md-7">
						<input type="text" placeholder="Title"  name="form_name" class="form-control" value="">
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="form-group">
					<label class="control-label col-md-3">Skill name:</label>
					<div class="col-md-7">
						<input type="text" placeholder="Skill name"  name="skill_1" class="form-control" value="">
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="form-group">
					<label class="control-label col-md-3">Text Description:</label>
					<div class="col-md-7">
						<input type="text" placeholder="Description" name="desc_1" class="form-control" value="">
					</div>
				</div>
				<input type="text" value="1" name="count" id="hdnCount" style="display:none"/>
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
		<div class="col-md-6" style="border-left:1px solid #dedede">
			<div  style="margin-left:35px;">
				<span style="font-size:20px;color:red;">Copying and pasting multiple skill<br>
					description at once
				</span>
                
                <form>
                	<textarea name="multi_skill" rows="10" class="form-control">
                		
                	</textarea>
                	<div class="clearfix"></div>
                	<br>
                	 <a href="#" id="btnget" class="btn btn-primary pull-right">Split </a>
                </form>

               	<form id="form_multi" method="get" action="{{ route('postskills',$form->id)}}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<label class="control-label col-md-3">Deadline</label>
					<div class="col-md-7">
						<div class="input-group date datepicker" data-date-autoclose="true" data-date-format="mm-dd-yyyy">
							<input class="form-control" type="text" name="deadline" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<br>
				<div class="form-group">
					<label class="control-label col-md-3">Title:</label>
					<div class="col-md-7">
						<input type="text" placeholder="Title"  name="form_name" class="form-control" value="">
					</div>
				</div>

				<div class="multidiv">

			
					
				</div>
				<input type="text" value="1" name="count" id="hdnCount2" style="display:none"/>
				 <input type="submit" class="btn btn-primary pull-right" value="Done" />
                </form>

			</div>
			<div class="clearfix"></div>
			<br>
		</div>
	</div>
</div>
@stop
