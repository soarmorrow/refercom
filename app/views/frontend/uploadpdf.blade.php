@extends('frontend/layouts/default')

@section('css')


@stop
@section('js')



 @stop

@section('content')
<div class="container-fliud" style="background-color:white">
                <!-- Notifications -->
        @include('frontend/notifications')

  <div class="padded container-fliud">
  	<form method="post" action="{{ route('upload/pdf') }}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token()}}"/>
		<div><input type="file" name="pdf" class="btn btn-lg btn-success btn-group" style="display:inline-block"  /><input type="submit" class="btn btn-lg btn-primary btn-group" style="display:inline-block" value="submit" /></div><br> 

   	
   	
     
    
        <br>
   
   	</form>
  </div>
</div>
@stop