@extends('frontend/layouts/default')

@section('css')
<link href="{{URL::asset('assets/stylesheets/datepicker.css')}}" media="all" rel="stylesheet" type="text/css" />
@stop

@section('js')
<script src="{{URL::asset('assets/javascripts/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){

		$('#edit').hide();
		$('#delete').hide();

    $('.datepicker').datepicker();

    $('#btnadd').click(function(){
        

    	$('#edit').hide();
    	$('#delete').hide();
        $('#add').fadeIn('slow');
        return false;
    });


    $('#btnedit').click(function(){
        
    
    	$('#delete').hide();
    	$('#add').hide();
    	$('#edit').fadeIn('slow');
         return false;
    });


    $('#btndelete').click(function(){

    	$('#edit').hide();
    	$('#add').hide();
    	$('#delete').fadeIn('slow');
       return false;
    });

     var k=0;
    $(document).on('click', '#btnAddSkill', function(){
            k++;
           $('.skill-container').append('<div class="form-group"><label class="control-label col-md-2">Skill '+k+'</label><div class="col-md-7"><input type="text" placeholder="skill name" name="skill_'+k+'" class="form-control" value="" /></div></div>');
            
            $('#count').val(k);

     });

  

 



	});
</script>
@stop

@section('content')
<div class="page-title">
	<h1>
		Letter Update
	</h1>

</div>
<div class="clearfix"></div>
<div class="row">

	<!-- Notifications -->
	@include('frontend/notifications')
	<!-- Container  -->
	<div class="col-lg-12">
		<div class="widget-container fluid-height clearfix">
			<div class="widget-content padded clearfix">
                <div class="clearfix"></div>
                <br>
                <div align="center">
                <a href="" id="btnadd" class="btn btn-success">add</a><a href="" id="btnedit" class="btn btn-info">edit</a><a href="" id="btndelete" class="btn btn-danger">delete</a>
                </div>
				  <div class="clearfix"></div>
                <br>
				<div id="add" class="container">
					<form id="formSubUpdate" method="post" action="{{ route('submissionupdate',$request->id) }}" class="form-horizontal">
		               <input type="hidden"  name="_token" value="{{ csrf_token() }}">

		               <input type="hidden" id="count" name="count" value="">
					  
						<div class="skill-container">

						</div>
                        <div align="right">
                        <a id="btnAddSkill" class="btn  btn-primary">add a new skill</a>
						</div>
						<div class="form-group">
						<label class="control-label col-md-2">Change Deadline</label>
							<div class="col-md-4">
								<div class="input-group date datepicker" data-date-format="mm-dd-yyyy">
									<input class="form-control" type="text" name="deadline" value="{{ date('m-d-Y', strtotime($request->deadline)) }}"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
							{{ $errors->first('deadline', '<label class="error">:message</label>') }}
						</div>
		                <div class="form-group">
		                	<label class="control-label col-md-2"></label>
		                	<div class="col-md-7">
		                	<input type="submit" class="btn btn-primary" value="ask for update" />
							</div>
						</div>
		                
					</form>
				</div>
				<div id="edit" class="container">
				<form id="formSubEdit" method="post" action="{{ route('submissionupdate-edit',$request->id) }}" class="form-horizontal">
		               <input type="hidden"  name="_token" value="{{ csrf_token() }}">

		            
					    <?php $fields = $request->form()->first()->fields()->get(); ?>
					    @foreach($fields as $field)
                          @if($field->type == 'skill')
                          <div class="form-group">
                          	<label class="control-label col-md-2">Edit Skill</label>
                          	<div class="col-md-7">
                          	<input type="text" placeholder="skill name" name="{{$field->id}}" class="form-control" value="{{ $field->label }}" />
                          	</div>
                          </div>
                          @endif
                        <br>
					    @endforeach
				
		                <div class="form-group">
		                	<label class="control-label col-md-2"></label>
		                	<div class="col-md-7">
		                	<input type="submit" class="btn btn-primary" value="ask for update" />
							</div>
						</div>
		                
					</form>
				</div>
				<div id="delete" class="container">
				<form id="formSubdelete"   class="form-horizontal">
		               <input type="hidden"  name="_token" value="{{ csrf_token() }}">

		            
					    <?php $fields = $request->form()->first()->fields()->get(); ?>
					    @foreach($fields as $field)
                          @if($field->type == 'skill')
                          <div class="form-group">
                          	<label class="control-label col-md-2">Edit Skill</label>
                          	<div class="col-md-7">
                          	<input type="text" placeholder="skill name" name="{{$field->id}}" class="form-control" value="{{ $field->label }}" />
                          	</div>
                          	<div class="col-md-2">
                             <a class="btn btn-danger" href="{{ URL::route('submissionupdate-del',array($request->id,$field->id)) }}">delete</a>
                          	</div>
                          </div>
                          @endif
                        <br>
					    @endforeach
				        
				        <a href="{{ route('submission-del-update',$request->id) }}" class="btn btn-primary" >Ask for Update</a>
		               
		                
					</form>
				</div>

			</div>
		</div>
	</div>

</div>

@stop