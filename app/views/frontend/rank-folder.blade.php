@extends('frontend/layouts/default')



@section('css')
<link href="{{URL::asset('assets/conrolfrog/css/controlfrog.css')}}" media="all" rel="stylesheet" type="text/css" />
<style type="text/css">
 .bg-personal
 {
   background-color: #9aff9a;
   color:Black;

 }
 .bg-professional
 {
  background-color: #7cb5ec;
  
}
.bg-academic
{

  background-color: #b40000;
  color: white;
}
.bg-well{

  background-color: #7cb5ec;
}
.cf-item:hover + .change{
  cursor: pointer !important;
  display: block !important;
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


// Colour settings
if(themeColour == 'white'){
  var metric = '#a9a9a9';
  var backColor = '#7d7d7d';
  var pointerColor = '#898989';   
  var pageBackgorund = '#fff';
  var blueColor = '#7cb5ec';
  var pieTrack = metric;
  var pieBar = backColor;
  var gaugeTrackColor = metric;
  var gaugeBarColor = backColor;
  var gaugePointerColor = '#ccc';
  var pieSegColors = [metric,'#868686','#636363','#404040','#1d1d1d'];    
}
else {
    //default to black
    var backColor = '#4f4f4f';
    var metric = '#f2f2f2'; 
    var pointerColor = '#898989'; 
    var pageBackgorund = '#2b2b2b'; 
    var pieSegColors = [metric,'#c0c0c0','#8e8e8e','#5b5b5b','#292929'];
    var pieTrack = backColor;
    var pieBar = metric;
    var gaugeTrackColor = '#4f4f4f';
    var gaugeBarColor = '#898989';
    var gaugePointerColor = metric;
  }

// Stores
var cf_rSVPs = [];
var cf_rGs = [];
var cf_rLs = [];
var cf_rPs = [];
var cf_rRags = [];
var cf_rFunnels = [];

var funData=[];
var funLabels=[];
var funYears=[];
var funYearsFolder=[];
var funRelation=[];
var funWriter=[];
var label=[];
var funOrganisation=[];


$(document).ready(function(){
	/*
	*	Copy the each() function for each Funnel chart you have
	* 	e.g. $('#cf-funnel-1').each(function(){.....}
   */								



        // Default Pie chart options
        window.cf_DefaultPieOpts = {};
        cf_DefaultPieOpts.segmentShowStroke = false;



        $('.score').each(function(){



          funData.push(parseInt($(this).html()));


        });
        console.log(funData);


        $('.years').each(function(){



          funYears.push(parseInt($(this).html()));


        });
        console.log(funYears);
        

        $('.folderyears').each(function(){



          funYearsFolder.push(parseInt($(this).html()));


        });
        console.log(funYearsFolder);



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


var k=0;
$('.cf-gauge').each(function(){


        // Gather IDs 
        var gId = $(this).prop('id');                   // Gauge container id e.g. cf-gauge-1
        var gcId = $('canvas', $(this)).prop('id');     // Gauge canvas id e.g. cf-gauge-1-g
        var gmId = $('.metric', $(this)).prop('id');    // Gauge metric id e.g. cf-gauge-1-m

        //Create a canvas
        var ratio = 2.1;
        var width = $('.canvas',$(this)).width();
        var height = Math.round(width/ratio);
        $('canvas', $(this)).prop('width', width).prop('height', height);

        // Set options      
        rGopts = {};
        rGopts.lineWidth = 0.30;
        rGopts.strokeColor = gaugeTrackColor;
        rGopts.limitMax = true;
        rGopts.colorStart = '#7cb5ec';
        rGopts.percentColors = void 0;  
        rGopts.pointer = {
          length: 0.7,
          strokeWidth: 0.035,
          color: gaugePointerColor
        };

        
        // Create gauge
        cf_rGs[gId] = new Gauge(document.getElementById(gcId)).setOptions(rGopts);
        cf_rGs[gId].setTextField(document.getElementById(gmId));

        // Set up values for gauge (in reality it'll likely be done one by one calling the function, not from here)
        
        



        updateOpts = {'minVal':'0','maxVal':'50','newVal':funYears[k].toString()};

        gaugeUpdate(gId, updateOpts);

        k++;


        // Responsiveness   
        $(window).resize(function(){

            //Get canvas measurements
            var ratio = 2.1;
            var width = $('.canvas', $('#'+gId)).width();
            var height = Math.round(width/ratio);

            cf_rGs[gId].ctx.clearRect(0, 0, width, height);
            $('canvas', $('#'+gId)).width(width).height(height);
            cf_rGs[gId].render();
          });

      });
$('.cf-gauge-folder').each(function(){


        // Gather IDs 
        var gId = $(this).prop('id');                   // Gauge container id e.g. cf-gauge-1
        var gcId = $('canvas', $(this)).prop('id');     // Gauge canvas id e.g. cf-gauge-1-g
        var gmId = $('.metric', $(this)).prop('id');    // Gauge metric id e.g. cf-gauge-1-m

        //Create a canvas
        var ratio = 2.1;
        var width = $('.canvas',$(this)).width();
        var height = Math.round(width/ratio);
        $('canvas', $(this)).prop('width', width).prop('height', height);

        // Set options      
        rGopts = {};
        rGopts.lineWidth = 0.30;
        rGopts.strokeColor = gaugeTrackColor;
        rGopts.limitMax = true;
        rGopts.colorStart = '#7cb5ec';
        rGopts.percentColors = void 0;  
        rGopts.pointer = {
          length: 0.7,
          strokeWidth: 0.035,
          color: gaugePointerColor
        };

        
        // Create gauge
        cf_rGs[gId] = new Gauge(document.getElementById(gcId)).setOptions(rGopts);
        cf_rGs[gId].setTextField(document.getElementById(gmId));

        // Set up values for gauge (in reality it'll likely be done one by one calling the function, not from here)
        
        



        updateOpts = {'minVal':'','maxVal':'','newVal':funYearsFolder[k].toString()};

        gaugeUpdate(gId, updateOpts);

        k++;


        // Responsiveness   
        $(window).resize(function(){

            //Get canvas measurements
            var ratio = 2.1;
            var width = $('.canvas', $('#'+gId)).width();
            var height = Math.round(width/ratio);

            cf_rGs[gId].ctx.clearRect(0, 0, width, height);
            $('canvas', $('#'+gId)).width(width).height(height);
            cf_rGs[gId].render();
          });

      });

      
  

 

}); // end doc ready

</script>


<script src="{{URL::asset('assets/conrolfrog/js/controlfrog.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/js/highcharts.js')}}" type="text/javascript"></script>
@stop

@section('content')

<?php    $i=1; ?>

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
    @foreach($seeker as $s)
    <p style="display:none"  class="ranks">{{$s->rank}}<p>
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




<?php $r=100; ?>
@if(isset($calculatedValue))
@foreach($calculatedValue as $key => $value)
      
         <div class="col-sm-3 cf-item">
                <header>
                    <h4><span></span>Score [{{$key}}]</h4>
                </header>
                <div class="content cf-svp clearfix" id="svp-{{$r}}">
                    <div class="chart" data-percent="{{(int)(($value/10)*100)}}" data-layout="l-6-12-6"></div>
                    <div class="metrics">
                        <span class="metric">{{(int)(($value/10)*100)}}</span>
                        <span class="metric-small"></span>
                    </div>
                </div>
            </div> <!-- //end cf-item -->
         
           
            
<?php $r++ ?>
@endforeach

@endif

<?php $s=100; ?>
@if(isset($calculatedValueYear))
@foreach($calculatedValueYear as $key => $value)
   <span style="display:none" class="folderyears">{{$value}}</span>      

@endforeach
@endif


@if(isset($calculatedValueYear))
@foreach($calculatedValueYear as $key => $value)
      <div class="col-sm-3 cf-item">
                <header>
                    <h4><span></span>Experience (Years) [{{$key}}]</h4>
                </header>
                <div class="content cf-gauge-folder" id="cf-gauge-folder-{{$s}}">
                    <div class="val-current">
                        <div class="metric" id="cf-gauge-folder-{{$s}}-m"></div>
                    </div>
                    <div class="canvas">
                        <canvas id="cf-gauge-folder-{{$s}}-g"></canvas>
                    </div>
                    <div class="val-min" >
                        <div class="metric-small-folder" style="display:none">0</div>
                    </div>
                    <div class="val-max" >
                        <div class="metric-small-folder" style="display:none">0</div>                       
                    </div>
                </div>
            </div> <!-- //end cf-item -->   
           
            
<?php $s++ ?>
@endforeach

@endif

@if(isset($fields))
<?php $i=1;$p=10;$k=21?>
    




     @foreach($fields as $f)
       @if ($f->type === 'skill')
          @foreach($f->submission()->get() as $f1)
        
          @foreach(json_decode($f1->option) as $op) 
          
          @if($i==1 || $i % 2 !=0)
         
        @if(!(array_key_exists($f->label,$calculatedValue)))   
         <div class="col-sm-3 cf-item">
                <header>
                    <h4><span></span>Score [{{$f->label}}]</h4>
                </header>
                <div class="content cf-svp clearfix" id="svp-{{$i}}">
                    <div class="chart" data-percent="{{($op/5)*100}}" data-layout="l-6-12-6"></div>
                    <div class="metrics">
                        <span class="metric">{{($op/5)*100}}</span>
                        <span class="metric-small"></span>
                    </div>
                </div>
            </div> <!-- //end cf-item -->
         
           
            <div class="change m-amber metric-small col-sm-3" style="display:none">
              <div class="arrow-left pull-left"></div>
             
              <div class="well padded bg-well" style="padding-left:30px;">
               @foreach($request as $r)<span>{{$r->relationship}}</span>@endforeach <span class="small">at</span> @foreach($writer as $w)<span>{{$w->organisation}}</span>@endforeach
              <br>
              <span class="small"> 
                           <?php
                           $datetime1 = new DateTime($r->seeker["know_from"]);
                           $datetime2 = new DateTime($r->seeker["know_to"]);
                          
                           $interval = $datetime1->diff($datetime2);
                           echo $interval->format('%y years %m months');
                           ?></span>
             </div>
              
           </div>
       @endif
        @else

       
         

      @endif

       <?php   $i++; ?>
          @endforeach
          @endforeach
        @endif

        @endforeach
        @endif


            <br>
<div class="clearfix"></div>
        <?php $j=1 ?>
         @if(isset($fields))
  @foreach($fields as $f)
       @if ($f->type === 'skill')
        
          @foreach($f->submission()->get() as $f1)
        
          @foreach(json_decode($f1->option) as $op) 
          
          @if($j==1 || $j % 2 !=0)
         
         
   
        @else
         @if(!(array_key_exists($f->label,$calculatedValueYear)))   
      
         <div class="col-sm-3 cf-item">
                <header>
                    <h4><span></span>Experience (Years) [{{$f->label}}]</h4>
                </header>
                <div class="content cf-gauge" id="cf-gauge-{{$j}}">
                    <div class="val-current">
                        <div class="metric" id="cf-gauge-{{$j}}-m"></div>
                    </div>
                    <div class="canvas">
                        <canvas id="cf-gauge-{{$j}}-g"></canvas>
                    </div>
                    <div class="val-min">
                        <div class="metric-small">0</div>
                    </div>
                    <div class="val-max">
                        <div class="metric-small">0</div>                       
                    </div>
                </div>
            </div> <!-- //end cf-item -->
         
       <div class="change m-amber metric-small col-sm-3" style="display:none">
              <div class="arrow-left pull-left"></div>
             
              <div class="well padded bg-well" style="padding-left:30px;">
               @foreach($request as $r)<span>{{$r->relationship}}</span>@endforeach <span class="small">at</span> @foreach($writer as $w)<span>{{$w->organisation}}</span>@endforeach
              <br>
              <span class="small"> 
                           <?php
                           $datetime1 = new DateTime($r->seeker["know_from"]);
                           $datetime2 = new DateTime($r->seeker["know_to"]);
                          
                           $interval = $datetime1->diff($datetime2);
                           echo $interval->format('%y years %m months');
                           ?></span>
             </div>
              
           </div>
        @endif   
      
      @endif

       <?php   $j++; ?>
          @endforeach
          @endforeach
        @endif

        @endforeach
        @endif



             @stop