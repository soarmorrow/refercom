@extends('frontend/layouts/default')

<!-- /*
*    Form-builder view
*
*/ -->



@section('css')
<link href="{{URL::asset('assets/stylesheets/bootstrap-select.css')}}" media="all" rel="stylesheet" type="text/css" />
<style type="text/css">
  .errorMsg{display: none;}.successMsg{display: none;}.container{background: white;}.confirm{position: absolute;margin: auto;top: 50%;right: 0;left: 0;bottom: 0;}
</style>
<link href="{{URL::asset('assets/css/main.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/css/star-rating.min.css')}}" rel="stylesheet">
@stop

@section('js')
<script src="{{URL::asset('assets/js/form.js')}}"></script>
<script src="{{URL::asset('assets/javascripts/bootstrap-select.js')}}"></script>
<script src="{{URL::asset('assets/js/star-rating.min.js')}}"></script>
@stop

@section('content')

<div class="container padded">

  <div class="col-md-12 text-primary" style="background-color:white;">
    
    <div class="clearfix"></div>
  <br>
<!-- form name and description -->
    <div class="pull-left">
     <div class="editName">
      <h3 class="form_title">{{ $form->name }}</h3>
    </div>
    <div class="editDesc">
      <h4 class="form_desc">Description</h4>
    </div>
  </div>
<!-- /form name and description -->
<br>

<!-- Edit,Save and Cancel buttons aligned to the right -->
<button id="edit" type="button" class="btn btn-warning pull-right">Edit</button>
<button id="cancel" type="button" class="btn btn-link pull-right">Cancel</button>
<button id="save" type="button" class="btn btn-primary pull-right">Save</button>
<!-- /Edit,Save and Cancel buttons aligned to the right -->
<div class="clearfix"></div>

<!-- Alert Boxes [success and Error]-->
<div class="alert alert-success alert-dismissible successMsg" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>success!</strong> saved
</div>

<div class="alert alert-danger alert-dismissible errorMsg" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Error!</strong> Failed!
</div>
<!-- /Alert Boxes [success and Error]-->

</div>  <!-- /col-md-12-->



<div id="mainHolder" class="container">

  <!-- The main wizard -->
  <div id="mainWizard">
    <div class="navbar" style="display:none">
      <div class="navbar-inner">
        <div class="container">
          <ul style="display:none">
            <li><a href="#tab1" data-toggle="tab"></a></li>

          </ul>
        </div>
      </div>
    </div>
    
    <div class="tab-content">

      <!-- Layout tab -->
      <div class="tab-pane" id="tab1">

        <div class="row">
          <!-- Source -->
          <div id="componentHolder" class="col-lg-6 col-sm-12">
            <h2>Drag components to...</h2>
            <hr>
            <div id="componentsTabPane">
              <ul class="nav nav-tabs" id="formtabs">
                <!-- Tab nav -->
                <li class="active"><a href="#inputs" data-toggle="tab">Input</a></li>
                <li><a href="#radioscheckboxes" data-toggle="tab">Radios / Checkboxes</a></li>
                <li><a href="#select" data-toggle="tab">Select</a></li>
                <li><a href="#other" data-toggle="tab">Other</a></li>
                <!-- <li><a href="#buttons" data-toggle="tab">Buttons</a></li> -->
              </ul>
              <form class="form-horizontal" id="components">
                <fieldset>
                  <div class="tab-content">

                    <!-- Input pane -->
                    <div id="inputs" class="sourceHolder connectedSortable tab-pane active">
                      <!-- Load input alternatives here -->
                    </div>

                    <!-- Radio pane -->
                    <div id="radioscheckboxes" class="sourceHolder connectedSortable tab-pane">
                      <!-- Load radio alternatives here -->
                    </div>

                    <!-- Select pane -->
                    <div id="select" class="sourceHolder connectedSortable tab-pane">
                      <!-- Load select alternatives here -->
                    </div>
                    <!-- Other pane -->
                    <div id="other" class="sourceHolder connectedSortable tab-pane">
                      <!-- Load select alternatives here -->
                    </div>

                    <!-- Button pane -->
                    <!--   <div id="buttons" class="sourceHolder connectedSortable tab-pane"> -->
                    <!-- Load button alternatives here -->
                    <!--  </div> -->

                  </div>
                </fieldset>
              </form>
            </div>
          </div>

          <!-- Target container to drop controls -->
          <div id="formVisualizer" class="col-lg-6 col-sm-12">
            <h2>Your Form</h2>
            <hr>
            <div class="alert alert-info">
              <button class="btn btn-link close" data-dismiss="alert">X</button>
              <strong>Note: </strong> Submit form fields after updating
            </div>
            <form class="form-horizontal area" id="targetForm">
              <legend class="">New Form</legend>
              <div id="target" class="connectedSortable">

              </div>
            </form>
            <br>
            <a href="#" class="btn btn-primary serialize">Save Action</a> 
            <p class="saving-show"><i>saving please wait..</i><img src="{{URL::asset('assets/images/loading.gif')}}"></p>
          </div>
        </div>  <!-- /row -->

      </div>   <!-- tab pane -->

      <!-- Libraries tab -->
      <!-- Source tab -->
      <!-- Preview tab -->
      <!-- Finish tab -->
      <!-- Wizard Pager -->
    </div>  <!-- /tab content -->
  </div>  <!-- /main-wizard -->
</div>  <!-- main holder -->

<div id="contextMenu" class="dropdown clearfix">
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
    <li><a id="edit" tabindex="-1" href="javascript:void(0)">Edit<span class="pull-right glyphicon glyphicon-pencil"></span></a></li>
  </ul>
</div>


<!-- /*
*   Continue and save button that will be visble only after saving actions 
*   and Continue button will be enabled only after saving [the save Button]
*/ -->
<div class="row clearfix">
  <div class="col-md-12"></div>
  <div id="uniqueDiv" class="text-center">
   <p style="color:black"></p>
 </div>
 <div class="pull-right pull-down final-save">
  <a href="{{route('send/form',$form->id)}}" ><button  type="button" class="btn btn-success" id="continueSubmit">Continue</button></a>
  <button type="button" class="btn btn-primary" id="saveForm">Save</button>
</div>
</div>


</div><!-- /container padded-->

<!-- /*
*   For Individual accounts creating form is optional 
*   so they can skip building it and move direct to request
*/ -->

@if(!$organization)
<div class="confirm col-md-5">
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
   <p><big>Do you want to skip to the request without creating form.</big></p>
   <div class="clearfix"></div>
   <br>
   <button type="button" class="btn btn-danger" data-dismiss="alert">No,I want to build form</button>
   <a href="{{route('send/form',$form->id)}}" ><button  type="button" class="btn btn-success" id="continueSubmit">Yes</button></a>
</div>
</div>
@endif

<!-- /*
*   Javascripts 
*    
*/ -->

<script src="{{URL::asset('assets/newfb3/js/jquery.sortable.min.js')}}"></script>
<script src="{{URL::asset('assets/newfb3/js/jquery-ui-1.10.4.custom.min.js')}}"></script>
<script src="{{URL::asset('assets/newfb3/js/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{URL::asset('assets/newfb3/js/jQuery.getComments.min.js')}}"></script>
<script src="{{URL::asset('assets/newfb3/js/jQuery.htmlClean.js')}}"></script>
<script src="{{URL::asset('assets/newfb3/js/FileSaver.js')}}"></script>
<script src="{{URL::asset('assets/newfb3/js/jquery.ui.touch-punch.min.js')}}"></script>
<script src="{{URL::asset('assets/newfb3/js/FormBuilder.js')}}"></script>  
 
<script type="text/javascript">
var form = {{ $form->id }};
var baseUrl = '{{ URL::to("/") }}';
var unique_id = '{{ $form->unique_id}}';
var fields = [];
var tabs = [];
var formfields=[];
$(function(){

<?php foreach ($formfields as $ff) {
  ?>
  formfields.push(<?=$ff?>);
  <?php
        
} ?>
});
</script>
<script src="{{URL::asset('assets/js/main-form-script.js')}}"></script> 

@stop