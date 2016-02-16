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
 <body class="login1">
<!-- Login Screen -->
    <div class="login-wrapper">
      <div class="login-container">

        <a href="./"><img width="100" height="30" src="{{URL::asset('assets/images/logo-login@2x.png')}}" /></a>
        <form action="{{ route('signin') }}" method="post">
        	<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

          <div class="form-group">
            <input class="form-control" placeholder="Username or Email" type="text" name="email" id="email" value="{{ Input::old('email') }}" >
            {{ $errors->first('email', '<span class="help-block">:message</span>') }}
          </div>
          <div class="form-group">
            <input class="form-control" placeholder="Password" type="password"  name="password" id="password" value="">
            {{ $errors->first('password', '<span class="help-block">:message</span>') }}<input type="submit" value="&#xf054;">
          </div>
          <div class="form-options clearfix">
            <a class="pull-right" href="{{ route('forgot-password') }}">Forgot password?</a>
            <div class="text-left">
              <label class="checkbox"><input type="checkbox" name="remember-me" id="remember-me" value="1"><span>Remember me</span></label>
            </div>
          </div>
        </form>
        <div class="social-login clearfix">
          <a class="btn btn-primary pull-left facebook" href="{{URL::action('AuthController@getFacebookAuthentication')}}"><i class="fa fa-facebook"></i>Facebook login</a><a class="btn btn-primary pull-right linkedin" href="{{URL::action('AuthController@getLinkedinAuthentication')}}"><i class="fa fa-linkedin"></i>linkedin login</a>
        </div>
        <p class="signup">
          Don't have an account yet? <a href="{{ route('signup') }}">Sign up now</a>
        </p>
      </div>
    </div>
    <!-- End Login Screen -->
</body>

 @stop