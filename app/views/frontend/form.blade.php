@extends('frontend/layouts/layout')


@section('css')
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="initial-scale=1.0, target-densitydpi=device-dpi" /><!-- this is for mobile (Android) Chrome -->
<meta name="viewport" content="initial-scale=1.0, width=device-height"><!--  mobile Safari, FireFox, Opera Mobile  -->

<link href="{{URL::asset('assets/stylesheets/wizard.css')}}" media="all" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/stylesheets/select2.css')}}" media="all" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/star-rating.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/stylesheets/datepicker.css')}}" media="all" rel="stylesheet" type="text/css" />
<style type="text/css">
  .temp{
    cursor: pointer;

    box-shadow: 0 0 5px #000;
    min-height: 100px;
    padding: 10px;
  }
  .hover-drop{

   background: #e5e5ea; 
  }
</style>

@stop

@section('js')
<script src="{{URL::asset('assets/javascripts/jquery.bootstrap.wizard.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/datatable-editable.js')}}" type="text/javascript"></script>    
<script src="{{URL::asset('assets/javascripts/jquery.easy-pie-chart.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/bootstrap-datepicker.js')}}" type="text/javascript"></script>

<script src="{{URL::asset('assets/javascripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/jquery.sparkline.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/js/frontend.form.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/js/star-rating.min.js')}}"></script>
<script src="{{URL::asset('assets/src/modernizr.js')}}"></script>
<!--[if lt IE 9]>
  <script type="text/javascript" src="{{URL::asset('assets/js/flashcanvas.js') }}"></script>
  <![endif]-->
  <script src="{{URL::asset('assets/js/jSignature.min.js') }}"></script>
  <script>

    $(function () {
      var c=1;
      $("#input-rating").rating();
      $( "[id^='slider-range-min-']" ).slider({
        range: "min",
        value: 5,
        min: 1,
        max: 50,
        slide: function( event, ui ) {
            // console.log(event);
            var id= event.target.attributes['id'].value;
            console.log(typeof(id));
            console.log(id);
            c=id.toString().split('-');
            console.log(c[3]);
            $( "#amount-"+c[3] ).val( "" + ui.value );
          }
        });
      $sliders= $( "[id^='slider-range-min-']" );
       // for (var i =  1; i < $sliders.length; i++) {
        console.log(c[3]);
        $( "#amount-"+c[3] ).val( "" + $( "#slider-range-min-"+c[3] ).slider( "value" ) ); 
       // };
      

      // Drag and Drop letter templates

      $('.temp').draggable({
       appendTo: "body",
       helper: "clone",
       cursorAt: { left: 0,top:0 },
       start: function(event, ui) { 
        $(ui.helper).css({
          width:'350px',
          height:'250px',
          'text-overflow':'ellipsis',
          overflow:'hidden',
          'white-space':'no-wrap'
        });
      },
    });

      $('#description').droppable({
        accept: ".ui-draggable",
        activeClass: "ui-state-hover",
        hoverClass: "hover-drop",
        over: function(event, ui) {

        },
        out: function(event, ui) {

        },    
        drop: function( event, ui ) {
          console.log('dropped');
        
          $('#description').val('');
          $('#description').val(ui.draggable[0].innerHTML);
        }
      });

     
      $('#candidate_skill').droppable({
        accept: ".ui-draggable",
        activeClass: "ui-state-hover",
        hoverClass: "hover-drop",
        over: function(event, ui) {

       },
       out: function(event, ui) {
      
       },    
       drop: function( event, ui ) {
        console.log('dropped');
     
        $('#candidate_skill').val('');
        $('#candidate_skill').val(ui.draggable[0].innerHTML);
       }
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
           <!--  <ul class="nav navbar-nav pull-right">
          
              <li class="dropdown user hidden-xs"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img src="{{URL::asset('assets/images/avatar-male.jpg')}}" height="34" width="34">John Smith<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('logout') }}">
                    <i class="fa fa-sign-out"></i>Logout</a>
                  </li>
                </ul>
              </li>
            </ul> -->
          </div>
          <button class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="logo" href="index.html">se7en</a>
          <form class="navbar-form form-inline col-lg-2 hidden-xs">
            <input class="form-control" placeholder="Search" type="text">
          </form>
        </div>
       <!--  <div class="container-fluid main-nav clearfix">
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
        </div> -->
      </div>
      <!-- End Navigation -->


      <div class="row">
        <div class="col-lg-12">
          <div class="widget-container fluid-height">
            <div class="widget-content">
              @if (!empty($form))
              @if ($request->submission_status == 1)
              Already Submitted
              @elseif( $request->deadline < date("m-d-Y H:i:s"))
              Request Expired
              @else
              <div class="wizard" id="wizard">
                <div class="padded">
                  <ul class="wizard-nav">
                    <li>
                      <a data-toggle="tab" href="#tab1">1</a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#tab2">2 </a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#tab3">3</a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#tab4">4</a>
                    </li>
                  </ul>
                  <div class="progress progress-striped active">
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" class="progress-bar" role="progressbar"></div>
                  </div>
                  <!--success msg-->
                  <div class="alert alert-success alert-dismissible successMsg" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>success!</strong> saved
                  </div>
                  <!--error msg-->
                  <div class="alert alert-danger alert-dismissible errorMsg" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Error!</strong> Failed!
                  </div>
                  <div class="tab-content">

                    <div class="tab-pane" id="tab1">
                      <h2>
                        Sender Details
                      </h2>
                      <p>The below user has requested the form. Please confirm his/her details</p>
                      <hr/>
                      <form class="form-horizontal" onsubmit="return false;" action="" method="post" id="formSeeker">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @if($seeker->first_name)
                        <div class="form-group">
                          <label class="control-label col-md-2">First Name</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="First Name" name="first_name" readonly class="form-control" value="{{ $seeker->first_name }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->last_name)
                        <div class="form-group">
                          <label class="control-label col-md-2">Last Name</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Last Name" name="last_name" readonly class="form-control" value="{{ $seeker->last_name }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->organisation)
                        <div class="form-group">
                          <label class="control-label col-md-2">Organisation</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Organisation" name="organisation" readonly class="form-control" value="{{ $seeker->organisation }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->position)
                        <div class="form-group">
                          <label class="control-label col-md-2">Position</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Position" name="position" readonly class="form-control" value="{{ $seeker->position }}">
                          </div>
                        </div>
                        @endif

                        <div class="form-group">
                          <label class="control-label col-md-2">e-mail</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="e-mail" name="seeker_email" readonly class="form-control" value="{{ $request->seeker_email }}">
                          </div>
                        </div>

                        @if($seeker->address1)
                        <div class="form-group">
                          <label class="control-label col-md-2">address1</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address1" name="address1" readonly class="form-control" value="{{ $seeker->address1 }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->address2)
                        <div class="form-group">
                          <label class="control-label col-md-2">address2</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address2" name="address2" readonly class="form-control" value="{{ $seeker->address2 }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->address3)
                        <div class="form-group">
                          <label class="control-label col-md-2">address3</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address3" name="address3" readonly class="form-control" value="{{ $seeker->address3 }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->zip)
                        <div class="form-group">
                          <label class="control-label col-md-2">zip</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="zip" name="zip" readonly class="form-control" value="{{ $seeker->zip }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->country)
                        <div class="form-group">
                          <label class="control-label col-md-2">country</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="country" name="country" readonly class="form-control" value="{{ $seeker->country }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->ostate)
                        <div class="form-group">
                          <label class="control-label col-md-2">state</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="state" name="state" readonly class="form-control" value="{{ $seeker->state }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->phone)
                        <div class="form-group">
                          <label class="control-label col-md-2">phone</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="phone" name="phone" readonly class="form-control" value="{{ $seeker->phone }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->mobile)
                        <div class="form-group">
                          <label class="control-label col-md-2">mobile</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="mobile" readonly name="mobile" class="form-control" value="{{ $seeker->mobile }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->fax)
                        <div class="form-group">
                          <label class="control-label col-md-2">fax</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="fax" readonly name="fax" class="form-control" value="{{ $seeker->fax }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->facebook)
                        <div class="form-group">
                          <label class="control-label col-md-2">facebook</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="facebook" readonly name="facebook" class="form-control" value="{{ $seeker->facebook }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->twitter)
                        <div class="form-group">
                          <label class="control-label col-md-2">twitter</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="twitter" readonly name="twitter" class="form-control" value="{{ $seeker->twitter }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->linkedin)
                        <div class="form-group">
                          <label class="control-label col-md-2">linkedin</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="linkedin" readonly name="linkedin" class="form-control" value="{{ $seeker->linkedin }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->google)
                        <div class="form-group">
                          <label class="control-label col-md-2">google</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="google" readonly name="google" class="form-control" value="{{ $seeker->google }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->google_scholar)
                        <div class="form-group">
                          <label class="control-label col-md-2">google_scholar</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="google_scholar" readonly name="google_scholar" class="form-control" value="{{ $seeker->google_scholar }}">
                          </div>
                        </div>
                        @endif

                        @if($seeker->github)
                        <div class="form-group">
                          <label class="control-label col-md-2">github</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="github" readonly name="github" class="form-control" value="{{ $seeker->github }}">
                          </div>
                        </div>
                        @endif

                        <div class="form-group">
                          <label class="control-label col-md-2">How long have you known {{ $seeker->first_name. ' '.$seeker->last_name }}?</label>
                          <div class="col-md-3">
                            <input type="text" placeholder="From" readonly name="know_from" class="datepicker form-control" data-date-autoclose="true" data-date-format="mm-dd-yyyy">
                          </div>
                          <div class="col-md-3">
                            <input type="text" placeholder="To" readonly name="know_to" class="datepicker form-control" data-date-format="mm-dd-yyyy">
                          </div>
                        </div>

                      </form>

                    </div>
                    <div class="tab-pane" id="tab2">
                      <h2>
                        Your Information
                      </h2>
                      <p>The user has provided some details about you. Please confirm his details</p>
                      <hr/>
                      <form class="form-horizontal" action="" onsubmit="return false;" method="post" id="formWriter">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                          <label class="control-label col-md-2">First Name</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="First Name" name="first_name" class="form-control" value="{{ $writer->first_name }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Last Name</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Last Name" name="last_name" class="form-control" value="{{ $writer->last_name }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Organisation</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Organisation" name="organisation" class="form-control" value="{{ $writer->organisation }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Position</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Position" name="position" class="form-control" value="{{ $writer->position }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">e-mail</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="e-mail" name="writer_email" class="form-control" value="{{ $request->writer_email }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address1</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address1" name="address1" class="form-control" value="{{ $writer->address1 }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address2</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address2" name="address2" class="form-control" value="{{ $writer->address2 }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address3</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address3" name="address3" class="form-control" value="{{ $writer->address3 }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">zip</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="zip" name="zip" class="form-control" value="{{ $writer->zip }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">country</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="country" name="country" class="form-control" value="{{ $writer->country }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">state</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="state" name="state" class="form-control" value="{{ $writer->state }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">phone</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="phone" name="phone" class="form-control" value="{{ $writer->phone }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">mobile</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="mobile" name="mobile" class="form-control" value="{{ $writer->mobile }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">fax</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="fax" name="fax" class="form-control" value="{{ $writer->fax }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">facebook</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="facebook" name="facebook" class="form-control" value="{{ $writer->facebook }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">twitter</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="twitter" name="twitter" class="form-control" value="{{ $writer->twitter }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">linkedin</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="linkedin" name="linkedin" class="form-control" value="{{ $writer->linkedin }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">google</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="google" name="google" class="form-control" value="{{ $writer->google }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">google_scholar</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="google_scholar" name="google_scholar" class="form-control" value="{{ $writer->google_scholar }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">github</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="github" name="github" class="form-control" value="{{ $writer->github }}">
                          </div>
                        </div>
                      </form>




                    </div>
                    @if ($request->tabbed )
                    @foreach($tabs as $t)
                    <div class="tab-pane" id="tab3">
                      <h2>

                      </h2>
                    </div>
                    @endforeach
                    @else
                    <div class="tab-pane" id="tab3">
                      <form class="form-horizontal" action="" method="post" id="tab_2">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <?php  $i=1; ?>
                        @foreach($fields as $f)

                        @if($f->type == 'textfield')
                        <div class="form-group">
                          <label class="control-label col-md-2">{{ $f->label }}</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="{{ $f->placeholder }}" name="name_{{ $f->id }}" class="form-control" value="">
                          </div>
                        </div>
                        @elseif($f->type == 'rating')
                        <div class="form-group">
                          <label class="control-label col-md-2">{{ $f->label }}</label>
                          <div class="col-md-7">

                            <input id="input-rating" name="name_{{ $f->id }}" value="4" type="text" class="rating form-control" placeholder="placeholder" min=0 max=5 step=0.2 data-size="xs">
                          </div>
                        </div>
                        @elseif($f->type == 'percentage')
                        <div class="form-group">
                          <!-- percentage -->
                          <label class="control-label col-md-2">{{ $f->label }}</label>
                          <div class="col-sm-7">
                            <p><input type="text" id="amount-{{$i}}"  class="amount" readonly name="name_{{ $f->id }}" style="border:0; color:#f6931f; font-weight:bold;"></p>
                            <div id="slider-range-min-{{$i}}"></div>
                          </div>
                        </div>
                        @elseif($f->type == 'skill')
                        <div class="form-group">
                          <label class="control-label col-md-2">{{ $f->label }}</label>
                          <div class="col-md-7">

                            <input id="input-rating" name="name_{{ $f->id }}[]" value="4" type="text" class="rating form-control" placeholder="placeholder" min=0 max=5 step=0.2 data-size="xs">
                          </div>
                        </div>

                        <div class="form-group">
                          <!-- percentage -->
                          <label class="control-label col-md-2">Year Of Experience in {{ $f->label }}</label>
                          <div class="col-sm-7">
                            <p><input type="text" id="amount-{{$i}}"  class="amount" readonly name="name_{{ $f->id }}[]" style="border:0; color:#f6931f; font-weight:bold;"></p>
                            <div id="slider-range-min-{{$i}}"></div>
                          </div>
                        </div>
                        @elseif($f->type == 'headline')
                        <h2>{{ $f->label }}</h2>

                        @elseif($f->type == 'paragraph')
                        <p>{{ $f->label }}</p>

                        @elseif($f->type == 'line')
                        <div class="form-group">
                         <hr>
                       </div> 
                       @elseif( $f->type == 'textarea')

                       <?php $options = json_decode($f->options , true); ?>

                       <div class="form-group">
                        <label class="control-label col-md-2">{{ $f->label }}</label>
                        <div class="col-md-7">
                          <textarea placeholder="{{ $f->placeholder }}" rows="{{ (!empty($options['rows'])) ? $options['rows'] : ''}}" name="name_{{ $f->id }}" class="form-control"></textarea>
                        </div>
                      </div>
                      @elseif( $f->type == 'checkbox')

                      <?php $options = json_decode($f->options , true); ?>

                      <div class="form-group">
                        <label class="control-label col-md-2">{{ $f->label }}</label>
                        <div class="col-md-7">
                          @foreach($options as $op)
                          <div class="checkbox-inline">
                            @foreach( $op as $key => $value )
                            <div class="checkbox-inline">
                              <label>
                                <input type="checkbox" name="name_{{ $f->id }}" value="{{$value}}">{{$key}}</label>
                              </div>
                              @endforeach
                            </div>
                            @endforeach
                          </div>
                        </div>

                        @elseif( $f->type == 'dropdown')

                        <?php $options = json_decode($f->options , true); ?>

                        <div class="form-group">
                          <label class="control-label col-md-2">{{ $f->label }}</label>
                          <div class="col-md-7">
                            <select class="form-control inline" name="name_{{ $f->id }}">
                              @foreach($options as $op)

                              @foreach( $op as $key => $value )
                              <option value="{{$value}}">{{$key}}</option>
                              @endforeach

                              @endforeach
                            </select>
                          </div>
                        </div>

                        @elseif( $f->type == 'multiselect')

                        <?php $options = json_decode($f->options , true); ?>

                        <div class="form-group">
                          <label class="control-label col-md-2">{{ $f->label }}</label>
                          <div class="col-md-7">
                            <select class="form-control inline" name="name_{{ $f->id }}[]" multiple="multiple">
                              @foreach($options as $op)

                              @foreach( $op as $key => $value )
                              <option value="{{$value}}">{{$key}}</option>
                              @endforeach

                              @endforeach
                            </select>
                          </div>
                        </div>


                        @elseif( $f->type == 'radiobutton')

                        <?php $options = json_decode($f->options , true); ?>

                        <div class="form-group">
                          <label class="control-label col-md-2">{{ $f->label }}</label>
                          <div class="col-md-7">
                            @foreach($options as $op)
                            <div class="checkbox-inline">
                              @foreach( $op as $key => $value )
                              <div class="checkbox-inline">
                                <label>
                                  <label class="radio-inline">
                                    <input name="name_{{ $f->id }}" value="{{$value}}" type="radio"><span>{{$key}}</span>
                                  </label>
                                </div>
                                @endforeach
                              </div>
                              @endforeach
                            </div>
                          </div>


                          @endif
                          <?php $i++; ?>
                          @endforeach

                          <h2>
                            More Details
                          </h2>
                          <div class="form-group">
                            <label class="control-label col-md-2">How would you rank {{ $seeker->first_name. ' '.$seeker->last_name }}</label>
                            <div class="col-md-7">

                             <input id="input-rating" name="rank" value="4" type="text" class="rating form-control" placeholder="placeholder" min=0 max=5 step=0.2 data-size="xs">

                           </div>
                         </div>
                       </form>
                     </div>
                     @endif
                     <div class="tab-pane" id="tab4">
                      <h2>
                       Finish
                     </h2>
                     <hr/>
                     <form class="form-horizontal" action="" onsubmit="return false;" method="post" id="formSubmit">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      

                      <div class="row">

                        <div class="form-group">
                          <label class="control-label col-md-2">Briefly describe how you were acquainted with the person you are recommending</label>
                          <div class="col-md-5">

                            <textarea id="description" name="description" rows="10" cols="50"></textarea>         
                            
                          </div>
                          <div class="col-md-5">
                           <h4><em>You can choose from these pre-made templates</em></h4>
                          @if($request->form_type == 'Personal')
                           <p id="personal_temp_1" class="temp">This letter serves to vouch for the personal character of ____________________. I have known him for 14 years, since the time his family moved into our neighborhood when he was a teenager.<br>  
                            I have always known _______________ to be of good character. He is generous and kind. Even as a teenager, he was always thinking of others. Several times, after he got done mowing his lawn he'd come over and mow mine as well, refusing to accept any payment from me.<br>  
                            Now that he is in his 20s and out of the house, I don't see _____________ as much. However, last summer he bought his two young children over to visit a few times and they were good natured and enjoyed being with their dad.<br>  
                            In my experience, _____________ has proven himself to be an honest, hard-working young man who loves his family. I trust him. 
                          </p>
                           @elseif($request->form_type == 'Academic' && $request->relationship == 'professor')
                            <p id="academic_temp" class="temp">
                              Dear Sir or Madam,<br>  
                              it is my pleasure to acquaint you with one of my most outstanding students, ______, who is keen to pursue the Doctor of Philosophy in Linguistics at your esteemed institution. <br> 
                              I have known ______ since 2010, when he enrolled into the Master of Science in Speech Analytics here at Oxbridge University. As part of this program, ______ took my course on Automated Speech Processing and joined my practical seminar on Pattern Processing.   <br>
                              ______ presented outstanding commitment to his studies, and finished his degree within the top 10% of his class. He was a quite remarkable student with a strong research interest. Among his peers, he stood out by always being up-to-date with currently topical discussions even within niches of linguistic research. The quality of his research work on his thesis project was compelling, and he managed to find beautifully simple solutions to very challenging problems.  <br>
                              Furthermore, I am certain that he would qualify for any means of financial aid that you could offer him, and I also strongly recommend him for a position as a teaching or research assistant. Should you have any questions with regards to ______, I will be pleased to answer them.<br>  
                              Sincerely, 
                            </p>
                           @elseif($request->form_type == 'Professional' && $request->relationship == 'supervisor') 
                             <p id="professional_temp" class="temp">
                              This letter serves to recommend __________________ for employment. I worked with him for two years at XYZ Company, where we were both sales representatives.  <br>
                              _________________ is one of the best salespeople I have ever met. He is skilled at sales, great at managing his time and incredibly organized. He is persistent without being annoying, and above all he gets results. In our department, ____________ set the bar high. <br>  
                              Obviously, sales is a highly competitive field. Each time our company set a sales target or held a contest, we knew ____________ would be the rep to beat. But holding the Top Sales title didn't go to his head. He was always happy to let the rest of us in on his secrets and work for the good of the entire company. He truly gets behind the product at hand, and is genuine and convincing as a salesperson. <br> 
                              It was always a pleasure to have ______________ in the office. He is a friendly, high-energy individual with a great sense of humor. Any company should be happy to have ________________ on board. 
                            </p>
                           @endif
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Briefly explain why the person you are recommending would be fit for this opportunity</label>
                          <div class="col-md-5">

                            <textarea id="candidate_skill" name="candidate_skill" rows="10" cols="50"></textarea> 
                            <p></p>        
                            
                          </div>
                          <div class="col-md-5">
                           
                            @if($request->form_type == 'Personal')
                             <p id="personal_temp_2" class="temp">
                               To Whom It May Concern:<br>  
                               It is my great pleasure to know ______________, and I wholeheartedly vouch for his personal character.<br>  
                               I have known _____________ for more than 10 years, since we first worked together at the local power plant. We quickly became friends, and now that we are each married with children, our entire families get together regularly.<br>  
                               I know it sounds cliché, but _____________ is the type of guy who would literally give you the shirt off his back. I remember one time we got off work after a 12-hour shift and my car was out of gas. ________________ siphoned gas from his own car's tank so that I could get home to my wife and new baby girl. <br> 
                               I trust ________________ without reservation. He knows that I'll lend him anything of mine and he'll do the same for me. He is honest to a fault, and the first to admit it when he has messed up. _______________ is a stand-up fellow; no two ways about it.<br>  
                               Sincerely, 
                             </p>
                             @endif
                         </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-md-2">Signature</label>
                          <div class="col-md-7">

                            <div id="signature"></div>
                          </div>
                        </div>

                        


                        <div class="text-center">

                         <button type="submit" class="btn btn-lg btn-primary btn-submit">Submit</button>
                         <button class="btn btn-lg btn-success btn-share" data-toggle="modal" data-target="#shareModal">Share</button>
                       </div>
                     </div>



                   </form>
                 </div>
               </div>

             </div>
             <div class="pager">
                  <!-- <div class="btn btn-default-outline btn-previous">
                    <i class="fa fa-long-arrow-left"></i>Back
                  </div> -->
                  <div style="display:none" class="btn btn-primary btn-save">
                    <i class="fa fa-floppy-o"></i>
                    Save
                  </div>
                  <div class="btn btn-primary-outline btn-next">
                    Continue<i class="fa fa-long-arrow-right"></i>
                  </div>
                </div>

                <div class="padded">  <a id="btnPreview" class="btn btn-lg btn-success">Get Preview</a> </div>
                <div id="preview" style="display:none" class="table table-bordered padded">
                  <div>
                    <?php 
                    $datefrom = new DateTime();
                    $datefrom->createFromFormat('m/d/Y', $seeker->know_from);
                    $dateto = new DateTime();
                    $dateto->createFromFormat('m/d/Y', $seeker->know_to);
                    $diff = $datefrom->diff($dateto);
                    $dt = new DateTime($request->updated_at);

                    $thedate = $dt->format('m/d/Y');
                    ?>

                    <div class="row">
                      <div class="col-lg-6">
                        <div class="widget-container fluid-height clearfix">
                          <div>
                            <p class="thdate">{{$thedate}}</p>
                            <p>  </p>
                            <p>{{$request->recipient_first_name}} {{$request->recipient_last_name}}</p>
                            <p>{{$request->recipient_position}}</p>
                            <p>{{$request->recipient_organisation}}</p>
                            <p>{{$request->recipient_address1}}</p>
                            <p>{{$request->recipient_zip}}</p>
                            <p>  </p>
                            <p>Dear Sir or Madam,</p>
                            <p> </p>
                            <p class="temp_chosen_desc"><!-- I am writing to recomend {{$seeker->first_name}} {{$seeker->last_name}},whom i have known for {{$diff->y}} years,
                              as a candidate for your company. I have nothing but positive things to say.{{$request->description}}.
                              There is no doubt in my mind that {{$seeker->first_name}} will be an excellent addition to {{$request->recipient_organisation}}. -->
                              {{$request->description}}
                            </p>
                            <p class="temp_chosen_skill">{{$request->candidate_skills}}</p>

                            <p></p>
                            <p>please do not hesitate to on contacting me at {{$writer->mobile}} or {{$request->writer_email}} if you have any further questions or requests.</p> 
                            <p></p>
                            <p>Regards</p>
                            <p></p>
                            <p>{{$writer->first_name}} {{$writer->last_name}}</p>
                            <p>{{$writer->position}}</p>
                            <p>{{$writer->organisation}}</p>
                            <p>{{$writer->address1}}</p>
                            <p>{{$writer->country}}</p>
                            <p>{{$writer->zip}}</p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- End -->

                  </div>   
                  <div style="display:none">
                   <h4>Your Information</h4> <br>

                   <strong>Email</strong> <span id="email"></span><br>
                   <strong>First name</strong> <span id="first_name"></span><br> 
                   <strong>Last name </strong> <span id="last_name"></span><br>
                   <strong>Address1 </strong><span id="address1"></span><br>
                   <strong>Address2</strong> <span id="address2"></span><br> 
                   <strong>Address3</strong> <span id="address3"></span> <br>
                   <strong> Phone</strong> <span id="phone"></span><br>
                   <strong>Mobile </strong><span id="mobile"></span> <br>
                   <strong>Fax </strong><span id="fax"></span><br>
                   <strong>Zip</strong> <span id="zip"></span> <br>
                   <strong>State </strong><span id="state"></span><br>
                   <strong>Country </strong><span id="country"></span><br> 
                   <strong>Organisation</strong> <span id="sorganisation"></span><br> 
                   <strong> Position </strong> <span id="sposition"></span><br>
                   <strong>Facebook </strong> <span id="sfacebook"></span><br> 
                   <strong>Twitter</strong> <span id="stwitter"></span><br> 
                   <strong>Linkedin </strong> <span id="slinkedin"></span><br> 
                   <strong>Google </strong> <span id="sgoogle"></span><br> 
                   <strong>Google scholar </strong> <span id="sgooglescholar"></span><br>
                   <strong>Github </strong> <span id="sgithub"></span><br> 
                   <strong>Know from </strong> <span id="knownfrom"></span><br>  
                   <strong>Know to </strong> <span id="knownto"></span><br> 
                   <strong>Rank</strong> <span id="rank"></span><br> 
                   <br>
                   <h4> Writer Information </h4> <br>
                   <strong> Email</strong> <span id="wemail"></span><br> 
                   <strong> First name</strong> <span id="wfirst_name"></span><br>  
                   <strong> Last name</strong> <span id="wlast_name"></span><br> 
                   <strong> Address1 </strong><span id="waddress1"></span><br> 
                   <strong> Address2</strong><span id="waddress2"></span><br> 
                   <strong> Phone</strong> <span id="wphone"></span><br> 
                   <strong> Mobile</strong> <span id="wmobile"></span> <br> 
                   <strong> Fax </strong><span id="wfax"></span><br> 
                   <strong> Zip </strong><span id="wzip"></span><br> 
                   <strong> State</strong> <span id="wstate"></span> <br> 
                   <strong> Organisation</strong> <span id="worganisation"></span><br> 
                   <strong> Position </strong><span id="wposition"></span><br> 
                   <strong> Facebook</strong> <span id="wfacebook"></span><br> 
                   <strong> Twitter</strong> <span id="wtwitter"></span><br> 
                   <strong> Linkedin</strong> <span id="wlinkedin"></span><br> 
                   <strong> Google </strong><span id="wgoogle"></span><br> 
                   <strong>Google scholar</strong> <span id="wgooglescholar"></span><br> 
                   <strong>Github</strong> <span id="wgithub"></span><br> 

                 </div>



               </div>
             </div>
             @endif
             @else
             The form is not active now
             @endif
           </div>
         </div>
       </div>
     </div>

     <div id="shareModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Share</h4>
          </div>
          <div class="modal-body">
           <form class="form-horizontal" onsubmit="return false;" action="" method="post" id="formShareSubmit">
            <div class="form-group">
              <label class="control-label col-md-2">email</label>
              <div class="col-md-7">
                <input  placeholder="enter e-mail to share.." email name="shareEmail"  type="email"  class="form-control"  />
              </div>
              <div class="clearfix"></div>
              <hr>
              <p class="sharelink">{{ route( 'pdf/submission', $request->id ) }}</p>
              <hr>

              <!--success msg-->
              <div class="alert alert-success alert-dismissible successMsgSh" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong>success!</strong> saved
              </div>
              <!--error msg-->
              <div class="alert alert-danger alert-dismissible errorMsgSh" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <strong>Error!</strong> Failed!
              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary btnShareSubmit">Share</button>

              <a href="#" target="_blank" class="btn btn-primary social-fb-share"><i class="fa fa-facebook"></i></a>
              <a href="#" target="_blank" class="btn btn-primary social-ln-share"><i class="fa fa-linkedin"></i></a>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @if (!empty($form))
    <script type="text/javascript">
      var baseUrl = '{{ URL::to("/") }}';
      var requestId = {{ $request->id }};
      var formId = {{ $form->id }};
      var $sigdiv;

      var fbshare = "http://www.facebook.com/sharer/sharer.php?u=";
      var lnshare = "https://www.linkedin.com/shareArticle?mini=true&url=";
      $('.social-fb-share').attr({
        'href': fbshare+$(this).data('link')
      });
      $('.social-ln-share').attr({
        'href': lnshare+$(this).data('link')
      });
      
    </script>
    @endif




    @stop