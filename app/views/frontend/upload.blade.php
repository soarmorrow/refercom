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
  	<form method="post" action="{{ route('upload/ocr') }}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token()}}"/>
		<div><input type="file" name="image" class="btn btn-lg btn-success btn-group" style="display:inline-block"  /><input type="submit" class="btn btn-lg btn-primary btn-group" style="display:inline-block" value="submit" /></div><br> 
	</form>
   	
   	<form method="post" action="{{ route('save/ocr') }}">
      <input type="hidden" name="_token" value="{{ csrf_token()}}"/>
   		<p><textarea  class="form-control" name="txtareaUpload" rows="10">
        @if($ocr = Session::get('ocr'))
          {{$ocr}}
        @endif
      </textarea></p>
      <div class="form-group">
       
        <!-- Text input -->
        <label class="control-label btn-group" for="textInput">Form name</label>
        
          <input id="textInput" name="form_name" type="text" placeholder="form name" class="form-control btn-group">
        
       
      </div>
        <br>
   		<input type="submit" class="btn btn-lg btn-success" value="Save" />
   	</form>
  </div>
</div>
@stop