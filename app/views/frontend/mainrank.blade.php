@extends('frontend/layouts/default')



@section('css')
  <link href="{{URL::asset('assets/conrolfrog/css/controlfrog.css')}}" media="all" rel="stylesheet" type="text/css" />
  <style type="text/css">
  .cf-item{

  
  }
  </style>
   
@stop
@section('js')

  <script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/moment.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/easypiechart.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/gauge.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/chart.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/jquery.sparklines.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/controlfrog-plugins.js')}}" type="text/javascript"></script>



    <script>
        var themeColour = 'white';

/*
*
* Funnel charts
*
*/

var funData=[];
var funLabels=[];
var funYears=[];
var funRelation=[];
var funWriter=[];
var label=[];
var funOrganisation=[];


$(document).ready(function(){
    /*
    *   Copy the each() function for each Funnel chart you have
    *   e.g. $('#cf-funnel-1').each(function(){.....}
    */                              
    $('.score').each(function(){



funData.push(parseInt($(this).html()));


});
    console.log(funData);

$('.years').each(function(){



funYears.push(parseInt($(this).html()));


});
console.log(funYears);

$('.users').each(function(){



funLabels.push($(this).html());


});
console.log(funLabels);

$('.relation').each(function(){



funRelation.push($(this).html());


});
console.log(funRelation);

$('.writers').each(function(){


funWriter.push($(this).html());


});
console.log(funWriter);
$('.organisation').each(function(){



funOrganisation.push($(this).html());


});
console.log(funOrganisation);

$('.users').each(function(i,a){

label[i]=funLabels[i]+'<span style="display:none">->ranked by '+funWriter[i]+', '+funRelation[i]+' at '+funOrganisation[i]+'</span>';
   

});


    
    $('#container').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: $('.title').html()
        },
        xAxis: {
            categories: label
        },
       
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            formatter: function() {
                return ' <b>' + this.x.toString().split("->")[1] + '</b> is <b> (' + this.y + '</b> '+ this.series.name+')';
            }
        },

        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal'
            }
        },
        series: [{
            name: 'years',
            data: funYears,
            color:'#ff943a'
        },
         {
            name: 'score',
            data: funData
            
        }]
    });

      $('#containerScore').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: $('.title').html()
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: label,
            title: {
                text: null
            }
        },

         tooltip: {
            formatter: function() {
                return ' <b>' + this.x.toString().split("->")[1] + '</b> is <b> (' + this.y + '</b> '+ this.series.name+')';
            }
        },

        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
       
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: false
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Score',
            data: funData
        },]
    });

 $('#containerYears').highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: $('.titleyears').html()
        },
        subtitle: {
            text: ''
        },
         colors: [
            '#ff943a'
            ],
        xAxis: {
            categories: label,
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            formatter: function() {
                return ' <b>' + this.x.toString().split("->")[1] + '</b> is <b> (' + this.y + '</b> '+ this.series.name+')';
            }
        },

        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: false
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Years',
            data: funYears
        },]
    });
    
}); // end doc ready

    </script>


  <script src="{{URL::asset('assets/conrolfrog/js/controlfrog.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/js/highcharts.js')}}" type="text/javascript"></script>
@stop

@section('content')

<?php   $i=1; ?>
     
     
     @foreach($fields as $f)
       @if ($f->type === 'skill')
          @foreach($f->submission()->get() as $f1)
        
          @foreach(json_decode($f1->option) as $op) 
          
          @if($i==1 || $i % 2 !=0)
         
          <p style="display:none"  class="score">{{$op}}<p>
          @else
          <p style="display:none" class="years">{{$op}}</p>
          @endif

       <?php   $i++; ?>
          @endforeach
          @endforeach
        @endif

        @endforeach

  @foreach($seeker as $s)
          <p style="display:none"  class="users">{{$s->first_name}}<p>
  @endforeach
    @foreach($writer as $w)
          <p style="display:none"  class="writers">{{$w->first_name}}<p>
  @endforeach
    @foreach($request as $r)
          <p style="display:none"  class="relation">{{$r->relationship}}<p>
  @endforeach
      @foreach($writer as $w)
          <p style="display:none"  class="organisation">{{$w->organisation}}<p>
  @endforeach


<span style="display:none" class="title">{{$f->label}} score rank comparison (score)</span>
<span style="display:none" class="titleyears">{{$f->label}} score rank comparison (years)</span>
        

<div id="containerScore" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div id="containerYears" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>


@stop