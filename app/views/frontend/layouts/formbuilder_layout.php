<?php 
$user = Sentry::getUser();
$avatar = md5(strtolower(trim($user->gravatar)));
$username = $user->first_name.' '.$user->last_name;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			Bootstrap
			@show
		</title>
		<meta name="keywords" content="your, awesome, keywords, here" />
		<meta name="author" content="Jon Doe" />
		<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />

		<!-- Mobile Specific Metas
		================================================== -->
	<!-- 	<meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

		<!-- CSS
		================================================== -->
    <link href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700" media="all" rel="stylesheet" type="text/css" />
	




    
	  <link href="{{URL::asset('assets/stylesheets/font-awesome.min.css')}}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/stylesheets/se7en-font.css')}}" media="all" rel="stylesheet" type="text/css" />
   


    <link href="{{URL::asset('assets/stylesheets/style.css')}}" media="all" rel="stylesheet" type="text/css" />

@yield('css')

    <script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
    <script src="{{URL::asset('assets/javascripts/bootstrap.min.js')}}" type="text/javascript"></script>
        


 


      <script src="{{URL::asset('assets/javascripts/dashboard.js')}}" type="text/javascript"></script>
      <script src="{{URL::asset('assets/javascripts/respond.js')}}" type="text/javascript"></script>

   
    


		<style>
		@section('styles')
		body {
			padding: 10px 0;
		}
		@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}">
		<link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png') }}">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	</head>

	<body class="page-header-fixed bg-1">
	
   <div class="modal-shiftfix">
      <!-- Navigation -->
      <div style="overflow: visible;" class="navbar navbar-fixed-top scroll-hide">
        <div class="container-fluid top-bar">
          <div class="pull-right">
            <ul class="nav navbar-nav pull-right">
          
              <li class="dropdown user hidden-xs"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img src="//secure.gravatar.com/avatar/{{ $avatar }}" height="34" width="34">{{ $username }}<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('logout') }}">
                    <i class="fa fa-sign-out"></i>Logout</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <button class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="logo" href="index.html">se7en</a>
          <form class="navbar-form form-inline col-lg-2 hidden-xs">
            <input class="form-control" placeholder="Search" type="text">
          </form>
        </div>
        <div class="container-fluid main-nav clearfix">
          <div class="nav-collapse">
            <ul class="nav">
              <li>
                <a href="{{ URL::route('profile') }}"><span aria-hidden="true" class="se7en-home"></span>Dashboard</a>
              </li>
             
             
              <li class="dropdown"><a {{ (Request::is('account/form*') ? ' class="current"' : '') }}  data-toggle="dropdown" href="#">
                <span aria-hidden="true" class="se7en-forms"></span>Forms<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  
                  <li>
                    <a href="{{route('forms')}}"><i class="fa fa-file"></i>All Forms</a>
                  </li>
                  <li>
                    <a href="{{route('new/form')}}"><i class="fa fa-file-o"></i>New Form</a>
                  </li>
                  
                </ul>
              </li>
               <li class="dropdown"><a {{ (Request::is('account/requests') ? ' class="current"' : '') }}   href="{{route('all/requests')}}">
                <span aria-hidden="true" class="se7en-pages"></span>Requests</a>
               
              </li>
              <li class="dropdown"><a {{ (Request::is('account/submissions') ? ' class="current"' : '') }}  href="{{route('all/submissions')}}">
                <span aria-hidden="true" class="se7en-tables"></span>Submissions</a>
                 </li>
              <li><a  href="">
                <span aria-hidden="true" class="se7en-charts"></span>Reports</a>
              </li>
             
              <li><a {{ (Request::is('account/profile*') ? ' class="current"' : '') }} {{ (Request::is('account/change-password*') ? ' class="current"' : '') }} {{ (Request::is('account/change-email*') ? ' class="current"' : '') }} data-toggle="dropdown" href="">
                <span aria-hidden="true" class=""><i class="fa fa-user"></i></span>Profile<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  
                     <li><a href="{{ URL::route('profile') }}">
                    <i class="fa fa-user"></i>Profile</a>
                  </li>
                   <li><a href="{{ URL::route('change-password') }}">
                    <i class="fa fa-user"></i>Change Password</a>
                  </li>
                   <li><a href="{{ URL::route('change-email') }}">
                    <i class="fa fa-envelope"></i>Change Email</a>
                  </li>
                  
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Navigation -->
     
        </div>
  <!--    </div>
    </div>-->
		
			
<div class="container-fluid padded">

			<!-- Content -->
			@yield('content')

			<hr />
		
</div>

<!-- Footer -->
      <!--<footer>
        <p>&copy; Company {{ date('Y') }}</p>
      </footer>-->

  <!-- Extra JS -->
      @yield('js')
	</body>
</html>
