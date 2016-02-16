@extends('frontend/layouts/layout')

@section('js')
  <script src="{{URL::asset('assets/js/mainjs.js')}}" type="text/javascript"></script>
@stop


@section('content')
@if(Session::has('success'))
  <div class="alert alert-success">
    <button class="close" data-dismiss="alert">x</button>
    {{ Session::get('success') }}</div>
  @endif
  @if(Session::has('error'))
  <div class="alert alert-danger">
    <button class="close" data-dismiss="alert">x</button>{{ Session::get('error') }}</div>
  @endif
<body class="login1 signup">
	 <!-- Login Screen -->
<div class="login-wrapper">
      <div class="login-container">
        <a href="./"><img width="100" height="30" src="{{URL::asset('assets/images/logo-login@2x.png')}}" /></a>
        <form method="post" action="{{ route('signup') }}" autocomplete="off">
        		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <div class="form-group">
            <input class="form-control" type="text" placeholder="Enter your email address" name="email" id="email" value="{{ Input::old('email') }}" >
            {{ $errors->first('email', '<span class="help-block">:message</span>') }}
          </div>
          <div class="form-group">
          	
            <input class="form-control" type="password" name="password" id="password" value=""  placeholder="Select a password">
            {{ $errors->first('password', '<span class="help-block">:message</span>') }}
          </div>
          <div class="form-group">
            <input class="form-control" type="password" name="password_confirm" id="password_confirm" value="" placeholder="Repeat your password"><input type="submit" value="&#xf054;">
         {{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
          </div>
           <div class="form-options">
            <label class="checkbox"><input name="organization" type="checkbox"><span>Organization</span></label>
          
            <label class="checkbox"><input type="checkbox"><span>I agree to the terms and conditions.</span></label>
          </div>
        </form>
       
        <div class="social-login clearfix">
          <a class="btn btn-primary pull-left facebook" href="{{URL::action('AuthController@getFacebookAuthentication')}}"><i class="fa fa-facebook"></i>Facebook login</a><a class="btn btn-primary pull-right linkedin" href="{{URL::action('AuthController@getLinkedinAuthentication')}}"><i class="fa fa-linkedin"></i>linkedin login</a>
        </div>
        <p class="signup">
          Already have an account? <a href="{{ route('signin') }}">Log in now</a>
        </p>

      </div>
    </div>
    <!-- End Login Screen -->

</body>
@stop
