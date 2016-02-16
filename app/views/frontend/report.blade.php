@extends('frontend/layouts/default')

@section('css')
<link href="{{URL::asset('assets/css/star-rating.min.css')}}" rel="stylesheet">
@stop
 @section('js')
<script src="{{URL::asset('assets/js/star-rating.min.js')}}"></script>
<script src="{{URL::asset('assets/javascripts/jquery.easy-pie-chart.js')}}"></script>
<script>
 var colorPie=['#81e970','#f46f50','#fab43b'];
    $(function () {
       $("#input-rating").rating();
           /*
    # =============================================================================
    #   Easy Pie Chart
    # =============================================================================
    */
 
   
    console.log(colorPie[parseInt(Math.floor((Math.random() * 3) + 1))]);
    $(".pie-chart1").easyPieChart({
      size: 200,
      lineWidth: 12,
      lineCap: "square",
      barColor: "#81e970",
      animate: 800,
      scaleColor: false
    });
    $(".pie-chart2").easyPieChart({
      size: 200,
      lineWidth: 12,
      lineCap: "square",
      barColor: "#f46f50",
      animate: 800,
      scaleColor: false
    });
    $(".pie-chart3").easyPieChart({
      size: 200,
      lineWidth: 12,
      lineCap: "square",
      barColor: "#fab43b",
      animate: 800,
      scaleColor: false
    });

    });
</script>
 @stop

@section('content')
<div class="container-fluid main-content">

  <div class="page-title">
    <h1>
      Report
    </h1>
  </div>

  <div class="container-fluid padded" style="background:white" >
    <h2 class="text-center">{{$form->name}}</h2>
    <div class="table-bordered padded">
      <div class="btn-group"><i class="fa fa-user fa-x text-muted"></i></div>
      <div class="btn-group"><td><b>{{$seeker->first_name}}{{$seeker->last_name}}</b></td></div><br>

      <div class="btn-group"><i class="fa fa-phone fa-x text-muted"></i></div>
      <div class="btn-group"><td><b>{{$seeker->mobile}}</i></td></div><br>

      <div class="btn-group"><i class="fa fa-envelope fa-x text-muted"></i></div>
      <div class="btn-group"><td><b>{{$seeker->google}}</b></td></div><br>

      <div class="btn-group"><i class="fa fa-map-marker fa-2x text-muted"></i></div>
      <div class="btn-group">{{$seeker->address1}}<br>{{$seeker->state}}<br>{{$seeker->country}}<br>{{$seeker->zip}}</div><br>
    </div>



    

    <h3 class="text-center">Skills</h3>
    <hr style="color:black">

    <div class="table-bordered padded">
     <?php
     $colors=['muted','default','primary','success','info','warning', 'danger'];
     $pieClass=['pie-chart1','pie-chart2','pie-chart3'];
     ?>
     <table>

      @foreach($fields as $f)
      @if(!(is_null($f->submission()->first())))
      <tr>
        <td><strong>{{$f->label}}:</strong> </td>
        <td>
          @if ($f->type === 'rating')
          <input id="input-rating" name="name_{{ $f->id }}" value="{{$f->submission()->first()->option}}" type="text" class="rating form-control" placeholder="placeholder" min=0 max=5 step=0.2 data-size="xs" disabled="disabled">
          @elseif ($f->type === 'multiselect')

          @foreach(json_decode($f->submission()->first()->option) as $op) 
          <i class="fa fa-circle text-<?php echo $colors[rand(0,6)] ?>"></i>{{$op}}
          @endforeach
          @elseif ($f->type === 'percentage')
          <div class="btn-group">
          <div data-percent="{{$f->submission()->first()->option}}" class="{{$pieClass[rand(0,2)]}} pie-chart pie-number easyPieChart" style="width: 200px; height: 200px; line-height: 200px;">
          {{$f->submission()->first()->option}}%
          <canvas height="200" width="200"></canvas></div>
          </div>
          @else
          {{$f->submission()->first()->option}}
          @endif
        </td>
      </tr>
      @endif
      @endforeach

    </table>

  </div>

  <h3 class="text-center">Additional Information</h3>
  <hr style="color:black">

    <!-- additional info -->

    


    <div class="table-bordered padded">
      <div class="btn-group"><i class="fa fa-user fa-x text-muted"></i></div>
      <div class="btn-group"><td><b>{{$writer->first_name}}{{$writer->last_name}}</b></td></div><br>

      <div class="btn-group"><i class="fa fa-envelope fa-x text-muted"></i></div>
      <div class="btn-group"><td><b>{{$request->writer_email}}</b></td></div><br>

      <div class="btn-group"><i class="fa fa-building-o fa-x text-muted"></i></div>
      <div class="btn-group"><td><b>{{$writer->organisation}}</b></td></div><br>

      <div class="btn-group"><i class="fa fa-suitcase fa-x text-muted"></i></div>
      <div class="btn-group"><td><b>{{$writer->position}}</b></td></div><br>      
    </div>
    
 
</div>
</div>
@stop