@extends('frontend/layouts/layout')

@section('css')
<link href="{{URL::asset('assets/stylesheets/wizard.css')}}" media="all" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/stylesheets/select2.css')}}" media="all" rel="stylesheet" type="text/css" />


@stop

@section('js')
<script src="{{URL::asset('assets/javascripts/jquery.bootstrap.wizard.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/datatable-editable.js')}}" type="text/javascript"></script>    
<script src="{{URL::asset('assets/javascripts/jquery.easy-pie-chart.js')}}" type="text/javascript"></script>

<script src="{{URL::asset('assets/javascripts/jquery.inputmask.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/javascripts/jquery.sparkline.min.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/js/frontend.form.js')}}" type="text/javascript"></script>

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
                        <div class="form-group">
                          <label class="control-label col-md-2">First Name</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="First Name" name="first_name" class="form-control" value="{{ $seeker->first_name }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Last Name</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Last Name" name="last_name" class="form-control" value="{{ $seeker->last_name }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Organisation</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Organisation" name="organisation" class="form-control" value="{{ $seeker->organisation }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Position</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Position" name="position" class="form-control" value="{{ $seeker->position }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">e-mail</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="e-mail" name="seeker_email" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address1</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address1" name="address1" class="form-control" value="{{ $seeker->address1 }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address2</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address2" name="address2" class="form-control" value="{{ $seeker->address2 }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address3</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address3" name="address3" class="form-control" value="{{ $seeker->address3 }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">zip</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="zip" name="zip" class="form-control" value="{{ $seeker->zip }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">country</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="country" name="country" class="form-control" value="{{ $seeker->country }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">state</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="state" name="state" class="form-control" value="{{ $seeker->state }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">phone</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="phone" name="phone" class="form-control" value="{{ $seeker->phone }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">mobile</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="mobile" name="mobile" class="form-control" value="{{ $seeker->mobile }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">fax</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="fax" name="fax" class="form-control" value="{{ $seeker->fax }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">facebook</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="facebook" name="facebook" class="form-control" value="{{ $seeker->facebook }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">twitter</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="twitter" name="twitter" class="form-control" value="{{ $seeker->twitter }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">linkedin</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="linkedin" name="linkedin" class="form-control" value="{{ $seeker->linkedin }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">google</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="google" name="google" class="form-control" value="{{ $seeker->google }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">google_scholar</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="google_scholar" name="google_scholar" class="form-control" value="{{ $seeker->google_scholar }}">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">github</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="github" name="github" class="form-control" value="{{ $seeker->github }}">
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
                            <input type="text" placeholder="First Name" name="first_name" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Last Name</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Last Name" name="last_name" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Organisation</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Organisation" name="organisation" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">Position</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="Position" name="position" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">e-mail</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="e-mail" name="writer_email" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address1</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address1" name="address1" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address2</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address2" name="address2" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">address3</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="address3" name="address3" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">zip</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="zip" name="zip" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">country</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="country" name="country" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">state</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="state" name="state" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">phone</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="phone" name="phone" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">mobile</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="mobile" name="mobile" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">fax</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="fax" name="fax" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">facebook</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="facebook" name="facebook" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">twitter</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="twitter" name="twitter" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">linkedin</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="linkedin" name="linkedin" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">google</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="google" name="google" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">google_scholar</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="google_scholar" name="google_scholar" class="form-control" >
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-2">github</label>
                          <div class="col-md-7">
                            <input type="text" placeholder="github" name="github" class="form-control" >
                          </div>
                        </div>
                      </form>
                    </div>
         
                      @foreach($tabs as $t)
                        <div class="tab-pane" id="tab3">
                          <h2>
                            Payment Information
                          </h2>
                        </div>
                      @endforeach
           
                      <div class="tab-pane" id="tab3">
                        <form class="form-horizontal" action="" method="post" id="tab_2">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          @foreach($fields as $f)
                            
                            @if($f->type == 'textfield')
                              <div class="form-group">
                                <label class="control-label col-md-2">{{ $f->label }}</label>
                                <div class="col-md-7">
                                  <input type="text" placeholder="{{ $f->placeholder }}" name="name_{{ $f->id }}" class="form-control" value="">
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
                                      <input type="checkbox" value="{{$value}}">{{$key}}</label>
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
                                  <select class="form-control inline">
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
                                        <input name="{{$key}}" value="{{$value}}" type="radio"><span>{{$key}}</span>
                                      </label>
                                    </div>
                                @endforeach
                              </div>
                                @endforeach
                                </div>
                              </div>

                            
                            @endif
                          @endforeach
                        </form>
                      </div>
                 
                     <div class="tab-pane" id="tab4">
                      <h2>
                       Finish
                      </h2>
                      <p class="text-center">Thanks for your valuable inputs!</p>
                      <hr/>
                      <form class="form-horizontal" action="" onsubmit="return false;" method="post" id="formSubmit">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="row">
                        <div class="text-center">
                         
                       <button class="btn btn-lg btn-primary btn-submit">Submit</button>
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
                  <div class="btn btn-primary btn-save">
                    <i class="fa fa-floppy-o"></i>
                    Save
                  </div>
                  <div class="btn btn-primary-outline btn-next">
                    Continue<i class="fa fa-long-arrow-right"></i>
                  </div>
                </div>
              </div>
        
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
         <p class="sharelink">{{URL::to("/")}}/forms/{{ $form->unique_id }}</p>
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
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@if (!empty($form))
  <script type="text/javascript">
  var baseUrl = '{{ URL::to("/") }}';
 
  var formId = {{ $form->id }};

  </script>
@endif
</body>
@stop