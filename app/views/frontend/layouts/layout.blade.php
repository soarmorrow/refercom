<!DOCTYPE html>
<html>
  <head>
    <title>
      @section('title')
      Referecom
      @show
    </title>
    <link href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700" media="all" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/stylesheets/bootstrap.min.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/stylesheets/font-awesome.min.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/stylesheets/se7en-font.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/stylesheets/style.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/stylesheets/custom.css')}}" media="all" rel="stylesheet" type="text/css" />

    @yield('css')

    <script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js" type="text/javascript"></script>
    <script src="{{URL::asset('assets/javascripts/bootstrap.min.js')}}" type="text/javascript"></script>
    
    @yield('js')

  <link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png') }}">

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
  </head>
 
    @yield('content')

</html>