@extends('frontend/layouts/default')

@section('js')
<script type="text/javascript">
$(".datepicker").datepicker( {
    format: " yyyy", // Notice the Extra space at the beginning
    viewMode: "years", 
    minViewMode: "years"
});

$(function(){
var i=1;
 $(document).on('click','.btn-add',function(){
      i++;
      $('#placeholderDiv').append('<br><div class="col-md-5"><select name="ddl_select_'+i+'" class="form-control"><option value="Secondary">Secondary</option><option value="bachelors">bachelors</option><option value="masters">masters</option><option value="doctorate">doctorate</option><option value="other">other</option></select></div><div class="clearfix"></div><br><div class="col-md-4"><input type="text" placeholder="Text" class="form-control" name="field_of_study_'+i+'" value="Degree 1 field of study" ></div><div class="col-md-4"><input type="text" placeholder="Text" class="form-control" name="topic_'+i+'" value="Topic" ></div><div class="col-md-4"><input type="text" placeholder="Text" class="form-control" name="institution_'+i+'" value="Degree 1 Institution" ></div><div class="clearfix"></div><br><div class="col-md-4"><input type="text" placeholder="From" name="from_'+i+'" class="datepicker form-control" data-date-autoclose="true" data-date-format="yyyy"></div><div class="col-md-4"><input type="text" placeholder="To" name="to_'+i+'" class="datepicker form-control" data-date-autoclose="true" data-date-format="yyyy"></div><div class="clearfix"></div><br>');
      return false;
 });

});
</script>
@stop

{{-- Page content --}}
@section('content')

	<div class="span9">
		@yield('account-content')
	</div>
</div>
@stop
