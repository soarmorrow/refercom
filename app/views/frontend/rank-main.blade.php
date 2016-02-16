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
.metric:hover + .change{
  cursor: pointer !important;
  display: block !important;
}


progress {
  width: 125px;
  height: 20px;
  margin: 5px auto;
  display: block;
  /* Important Thing */
  -webkit-appearance: none;
  border: none;
}

/* All good till now. Now we'll style the background */
progress::-webkit-progress-bar {
  background: white;
  border-radius: 0px;
  padding: 2px;
  box-shadow: 0 1px 0px 0 rgba(255, 255, 255, 0.2);
}

/* Now the value part */
progress::-webkit-progress-value {
  border-radius: 0px;
  box-shadow: inset 0 1px 1px 0 rgba(255, 255, 255, 0.4);
  background:#7cb5ec;

  /* Looks great, now animating it */
  background-size: 25px 14px, 100% 100%, 100% 100%;
  -webkit-animation: move 5s linear 0 infinite;
}

/* That's it! Now let's try creating a new stripe pattern and animate it using animation and keyframes properties  */

@-webkit-keyframes move {
  0% {background-position: 0px 0px, 0 0, 0 0}
  100% {background-position: -100px 0px, 0 0, 0 0}
}

/* Prefix-free was creating issues with the animation */



</style>
<style type="text/css">
  .form-control{border-color:#66afe9;outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6);box-shadow:inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(102,175,233,0.6)}
    .container-fluid{background: #fff}
     .errorMsg{display: none;}.successMsg{display: none;}.container{background: white;}.confirm{position: absolute;margin: auto;top: 50%;right: 0;left: 0;bottom: 0;}
   a{
    cursor: pointer;
   }
   a:hover{
        
        color: #007aff;  
   }
</style>
<style type="text/css">
  .hover-drop{

   background: #e5e5ea; 
  }
  .drop-alert-box{

    position: fixed;
    top: 50%;
    left: 45%;
    z-index: 10000;
    display: none;
  }
  .drop-alert-box-not{
   position: fixed;
    top: 50%;
    left: 45%;
    z-index: 10000;
    display: none;

  }
  .alert-drop-not{
    background: #b31c22;
    color: white;
    border: none;
    box-shadow: 0 0 5px #000;
    -webkit-box-shadow: 0 0 5px #000;
    -moz-box-shadow: 0 0 5px #000;

  }
  .alert-drop{
    background: #007aff;
    color: white;
    border: none;
    box-shadow: 0 0 5px #000;
    -webkit-box-shadow: 0 0 5px #000;
    -moz-box-shadow: 0 0 5px #000;

  }
  .close{
    color: white;
  }
  .ondragDiv{
   box-shadow: 0 0 5px #000;
   -webkit-box-shadow: 0 0 5px #000;
   -moz-box-shadow: 0 0 5px #000;
  
   background:#ccc;
   padding: 7px;
   font-size: 22px;

  }
  li.ui-draggable-dragging {
    list-style:none;
}
.code {
  padding: 2px 4px;
  color: #d14;
  white-space: nowrap;
  background-color: #f7f7f9;
  
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


//    $(".slider-range-amount").html("$" + $(".slider-range").slider("values", 0) + " - $" + $(".slider-range").slider("values", 1));


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



}); // end doc ready
var val0=0;
var val100=0;
var Prof=0;
var aca=0;
var Pr=0;
$(function(){
 


   //slider range
   $(".slider-range").slider({
    range: true,
    values: [33, 66],
    slide: function(event, ui) {
      return $(".slider-range-amount").html("" + ui.values[0] + " ---------- " + ui.values[1]);
    }
  });
   $(".slider-range-amount").html("" + $(".slider-range").slider("values", 0) + " ------------- " + $(".slider-range").slider("values", 1));
   
   
   var pro1 = $('.profess-value').html();
   var acad1 = $('.aca-value').html();
   var pers1 =$('.pers-value').html();


   
   var count =0;
   if(parseInt(pers1) > 0 || pers1 != ' ')
   {
    count++;
   }
   if(parseInt(acad1) > 0 || pers1 != ' ')
   {
    count++;
   }
   if(parseInt(pro1) > 0 || pers1 != ' ')
   {

    count++;

   }

   if(count == 1)
   {

     $('.range-div').hide();
   }
   if(parseInt(pers1) == 0 || pers1 == ' ')
   {
    $(".slider-range").slider({
      range: true,
      values: [50, 100],
      slide: function(event, ui) {
        // return $(".slider-range-amount").html("" + ui.values[0] + " ---------- " + ui.values[1]);
        return false;
      }
    });
    
    val0 =  $(".slider-range").slider("values", 0);      
    val100= $(".slider-range").slider("values", 1);

    $('#prof').val(val0);
    $('#aca').val(val100-val0);
    $('#pers').val(100-val100);
    $(".slider-range-amount").html("" + $(".slider-range").slider("values", 0) + " ------------- " + $(".slider-range").slider("values", 1));
    
     // $('.ui-slider .ui-slider-handle:nth-of-type(2)').draggable(false);
     

   }

   if(parseInt(pro1) == 0 || pro1 == ' ')
   {
    $(".slider-range").slider({
      range: true,
      values: [0, 50],
      slide: function(event, ui) {
        // return $(".slider-range-amount").html("" + ui.values[0] + " ---------- " + ui.values[1]);
        return false;
      }

    });
    val0 =  $(".slider-range").slider("values", 0);      
    val100= $(".slider-range").slider("values", 1);

    $('#prof').val(val0);
    $('#aca').val(val100-val0);
    $('#pers').val(100-val100);

    $(".slider-range-amount").html("" + $(".slider-range").slider("values", 0) + " ------------- " + $(".slider-range").slider("values", 1));
  }
  if(parseInt(acad1) == 0 || acad1 == ' ')
  {
    $(".slider-range").slider({
      range: true,
      values: [50,50 ],
      slide: function(event, ui) {
        // return $(".slider-range-amount").html("" + ui.values[0] + " ---------- " + ui.values[1]);
        return false;
      }
    });

    val0 =  $(".slider-range").slider("values", 0);      
    val100= $(".slider-range").slider("values", 1);
    
    $('#prof').val(val0);
    $('#aca').val(val100-val0);
    $('#pers').val(100-val100);
    $(".slider-range-amount").html("" + $(".slider-range").slider("values", 0) + " ------------- " + $(".slider-range").slider("values", 1));
  }



  //  $('.ui-slider .ui-slider-handle:first').disabled(true);
  //  $('.ui-slider .ui-slider-handle').eq(1).disabled(true);

  $('#btn-redraw').click(function(){
    val0 =  $(".slider-range").slider("values", 0);      
    val100= $(".slider-range").slider("values", 1);
    
    $('.cf-svp').each(function(){
      cf_rSVPs[$(this).prop('id')] = {};
      rSVP($(this));
      
      Prof=val0/100;
      aca=(val100-val0)/100;
      Pr=(100-val100)/100;
      
      $('#prof').val(val0);
      $('#aca').val(val100-val0);
      $('#pers').val(100-val100);

      

      console.log(Prof);
      console.log(aca);
      console.log(Pr);

      var pro = $('.profess-value').html();
      var acad = $('.aca-value').html();
      var persona =$('.pers-value').html();

      
      var updateValue= parseInt(((Prof*pro + aca*acad + Pr*persona)/5)*100);
      
      console.log(updateValue);
      
  // Call EasyPieChart update function
  cf_rSVPs[$(this).prop('id')].chart.update(updateValue);
  // Update the data-percent so it redraws on resize properly
  $('#svp-1 .chart').data('percent', updateValue);
  // Update the UI metric
  $('.metric', $('#'+$(this).prop('id'))).html(''+updateValue);




});


    return false;
    

  }); 


 // $( ".slider-range" ).slider( "option", "disabled", true );
});

function slide(event, ui){
    var result = true;
    // if (ui.value > 150){
    //     $(this).slider( "value" , 150 );
    //     result = false;
    // }
    // $( "#amount" ).val( $(this).slider( "value") );
    return false;
}

$('.code').click(function(){
     
   var code = $(this).text().toString().trim();

   $.ajax({
    url: baseUrl+'/ajax/getSkillScore',  
    method:'post',
    data:'code='+code,
    success: function(data){
     console.log(data.status);
     if(data.status=="success")
     {
        console.log(data.writer);
        console.log(data.score);
        console.log(data.year);
          $("#skillshow").show('hide');
        $("#writer_name").text(data.writer);

        $("#ajaxscore").text(data.score);

        $("#ajaxyear").text(data.year);
        $("#skillshow").show('slow');

     }
     else
     {

     }
   },
   dataType: 'json'
 }); 

});

</script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="{{URL::asset('assets/conrolfrog/js/controlfrog.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/js/highcharts.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(function(){

    $("input:text").focus(function() { $(this).select(); } );

    $('#btnDone').click(function(){
      var data = $("#skillform").serialize();
               data += '&job_form_id='+job_form_id;
    
      $.ajax({
        url: baseUrl+'/ajax/skill-paste-done',
        method:'post',
        data: data,
        success: function(data){
          if(data.status=="success")
          {
               
              var left = data.leftout;
                 var leftout ="";
                 var i=0;
                 if(typeof left != 'undefined'){
             $.each(left, function(k, v) {
                if(i==0)
                    leftout += v;
                else
                  leftout += ','+v;

                i++;

              });
               $('.leftoutskills').text(leftout);
                $('#successDiv').show();
             }
             else
             {
               $('#successDivComplete').show();
              
             }

              

             
          }
          else
          {
                
               $('.errorMsg').hide();
            $('.errorMsg').html('<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Please make sure the correct skill codes are pasted before hitting Done !');
            $('.errorMsg').show();



          }
        },
        dataType: 'json'
        });
  });
   
  $( "#draggable li" ).draggable({
      appendTo: "body",
        cursorAt: { left: 0,top:0 },
       helper: function (e, ui) {
        return $(this).clone(true).html("<div class='ondragDiv' >"+$(this).find('.code').text()+'</div>'); //Replaced $(ui) with $(this)
      },
      start: function(event, ui) { 
           
       },
     
    });
$(".dropskill").droppable({
   accept: "#draggable li",
  activeClass: "ui-state-default",
  hoverClass: "ui-state-hover",
  over: function(event, ui) {

   $(this).addClass('hover-drop');


 },
 out: function(event, ui) {
   $(this).removeClass('hover-drop');
 }, 
  drop: function( event, ui ) {
     var code = ui.draggable.data('code');
  
    $(this).val(code);
  }
});



});

</script>

@stop

@section('content')
<!--          LinkedIn API timeline         -->
<div class="container">
  <div class="clearfix"></div>
  <div class="row">
    <div class="widget-container fluid-height clearfix container-fluid">

      <div class="widget-content padded">


        <div class="clearfix"></div>
        <br>
        <div id="mytimeline"></div>

        <div class="clearfix"></div>
        <br>
        <div style="display:none" id="info"></div>
      </div>
    </div>
  </div>
</div>


<!--          /LinkedIn API timeline         -->

<!--          Main Ranking         -->
<div class="clearfix"></div>
<br>
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




            <?php $l=0;$m=0;$n=0;$z=0; $Professional=0;$Academic=0;$Personal=0; ?>

            @foreach($request as $r)


            @if(isset($s->rank))

            @if($r->form_type == "Professional")

            <?php $Professional += $r->seeker["rank"]; ?> 
            

            <?php $l++ ?>
             @endif  



             @if($r->form_type == "Academic")


             <?php $Academic += $r->seeker["rank"];  $m++ ?>

             @endif  



             @if($r->form_type == "Personal")




             <?php $Personal += $r->seeker["rank"];  $n++; ?>
             @endif 



             @endif  


             @endforeach
            
 <!-- Professional Single Pie chart -->           
             @if($l != 0)
             <div class="col-sm-3 cf-item">
              <header>
                <h4><span></span>Professional</h4>
              </header>
              <div class="content">
                <div class="cf-svmc">
                  <div class="metric">{{ number_format((float)(($Professional/$l)*2), 1, '.', '')  }}</div>
                  <!-- show on hover -->

                  <div class="change m-red metric-small" style="display:none">
                    <div class="arrow-down"></div>
                    <div class="well padded bg-professional">

                      @foreach($request as $r)
                      @if(isset($s->rank))

                      @if($r->form_type == "Professional")  

                     <span class="small">{{$r->relationship}}</span><span class="small"> at </span> <span class="small">{{$r->writer["organisation"]}}</span>
                     <br>
                     <span class="small"> 
                       <?php
                       $datetime1 = new DateTime();
                       $datetime1->createFromFormat('m/d/Y', $r->seeker["know_from"]);
                       $datetime2 = new DateTime();
                       $datetime2->createFromFormat('m/d/Y', $r->seeker["know_to"]);

                       $interval = $datetime1->diff($datetime2);
                       echo $interval->format('%y years %m months');
                       ?></span>
                     
                     
                     @endif 
                     @endif 
                     @endforeach

                     </div>

                   </div>

                   <!-- End show hover -->

                </div>

              </div>
            </div> 
             @endif
 
  <!--  Academic single valued piechart -->
                @if($m != 0)
             <div class="col-sm-3 cf-item">
              <header>
                <h4><span></span>Academic</h4>
              </header>
              <div class="content">
                <div class="cf-svmc">

                  <div class="metric">{{ number_format((float)(($Academic/$m)*2), 1, '.', '') }}</div>
                 
                  <!-- show on hover -->

                  <div class="change m-red metric-small" style="display:none">
                    <div class="arrow-down"></div>
                    <div class="well padded bg-academic">

                      @foreach($request as $r)
                      @if(isset($s->rank))

                      @if($r->form_type == "Academic")  

                     <span class="small">{{$r->relationship}}</span><span class="small"> at </span> <span class="small">{{$r->writer["organisation"]}}</span>
                     <br>
                     <span class="small"> 
                       <?php
                       $datetime1 = new DateTime();
                       $datetime1->createFromFormat('m/d/Y', $r->seeker["know_from"]);
                       $datetime2 = new DateTime();
                       $datetime2->createFromFormat('m/d/Y', $r->seeker["know_to"]);
                       $interval = $datetime1->diff($datetime2);
                       echo $interval->format('%y years %m months');
                       ?></span>
                     
                     
                     @endif 
                     @endif 
                     @endforeach

                     </div>

                   </div>

                   <!-- End show hover -->

                </div>

              </div>
            </div> 
              @endif


       <!-- Personal Single Pie chart -->           
             @if($n != 0)
             <div class="col-sm-3 cf-item">
              <header>
                <h4><span></span>Personal</h4>
              </header>
              <div class="content">
                <div class="cf-svmc">
                  <div class="metric">{{  number_format((float)(($Personal/$n)*2), 1, '.', '') }}</div>
                  
                   <!-- show on hover -->

                  <div class="change m-red metric-small" style="display:none">
                    <div class="arrow-down"></div>
                    <div class="well padded bg-personal">

                      @foreach($request as $r)
                      @if(isset($s->rank))

                      @if($r->form_type == "Personal")  

                     <span class="small">{{$r->relationship}}</span><span class="small"> at </span> <span class="small">{{$r->writer["organisation"]}}</span>
                     <br>
                     <span class="small"> 
                       <?php
                       $datetime1 = new DateTime();
                       $datetime1->createFromFormat('m/d/Y', $r->seeker["know_from"]);
                       $datetime2 = new DateTime();
                       $datetime2->createFromFormat('m/d/Y', $r->seeker["know_to"]);

                       $interval = $datetime1->diff($datetime2);
                       echo $interval->format('%y years %m months');
                       ?></span>
                     
                     
                     @endif 
                     @endif 
                     @endforeach

                     </div>

                   </div>

                   <!-- End show hover -->

                </div>

              </div>
            </div> 
            @endif



             <?php  if($m==0){

               $m++;
             }
             if($l==0)
             {

              $l++;
            } 
            if($n==0)
            {

              $n++;
            }

            $divider=0;
            if($Professional > 0)
            {

              $divider += 1;
            }
            if($Academic > 0)
            {
              $divider += 1;
            }
            if($Personal > 0)
            {
              $divider += 1;
            }


            ?>

            <span style="display:none" class="profess-value">{{$Professional/$l}}</span>
            <span style="display:none" class="aca-value">{{$Academic/$m}}</span>
            <span style="display:none" class="pers-value">{{$Personal/$n}}</span>

            <div class="row padded">
              <div class="col-sm-3 cf-item">
                <header>
                  <h4><span>Main Ranking</span></h4>
                </header>
                <div class="content redraw-content cf-svp clearfix" id="svp-1">
                  <div class="chart" data-percent="{{(int)(((($Personal/$n)+($Professional/$l)+($Academic/$m))/(5*$divider))*100)}}" data-layout="l-6-12-6"></div>
                  <div class="metrics">
                    <span class="metric redraw-block">{{((int)(((($Personal/$n)+($Professional/$l)+($Academic/$m))/(5*$divider))*100))}}</span>
                    <span class="metric-small"></span>
                  </div>
                </div>
              </div> <!-- //end cf-item -->
            </div>


            <?php $z++; ?>




            <div class="panel col-lg-4 padded" style="background:#ddd">
             <div class="padded">
              <table class="pull-left">
               <tr><td><h4>Skills</h4></td><td><h4>Score</h4></td></tr>
               <?php $r=100; ?>
               @if(isset($calculatedValueMscore))
               @foreach($calculatedValueMscore as $key => $value)

               <tr> <td><b> @if($markskills != null) @if(array_key_exists($key,$markskills)) <span class="text-danger">{{$key}}</span>@else {{$key}}  @endif @else {{$key}} @endif </b></td><td> <b>{{round($value,1)}}</b> </td><td><progress max="10" value="{{$value}}"></progress></td><td>&nbsp</td></tr>
               
               <?php $r++ ?>
               @endforeach

               @endif
             </table>
             <table class="">
              <tr><td><h4>Years</h4></td></tr>
              <?php $s=100; ?>
              @if(isset($calculatedValueYear))
              @foreach($calculatedValueYear as $key => $value)

              <tr><td><div style="height:32px"><b>{{$value}}</b></div></td><!-- <td><progress max="100" value="{{$value}}"></progress></td> --> </tr>
              @endforeach
              @endif
            </table>
            

          </table>
        </div>
        
      </div>
      
      <br>
      <div class="clearfix"></div>
      <div class="padded">
       <table cellpadding="10" cellspacing="10" style="float:right" width="50%">
        <tr>
        <td>
          @if(isset($uniqueform->unique_id))
          <div class="col-lg-12">

      <div class="widget-container fluid-height clearfix" style="min-height:500px;">
        <div class="widget-content padded clearfix">
          <br>
          <strong style="font-size:24px;color:black">{{$uniqueform->name}}</strong>
          <div class="clearfix"></div>
          <br>
          <form id="skillform">
          <?php $i=1 ?>
          @foreach($uniquefields as $ufield)
          @if($ufield->placeholder !=  '' || !empty($ufield->placeholder))
          
          <div class="row">
            <div class="col-md-7">
              <span style="color:black">&#9632; &nbsp; &nbsp; &nbsp;</span><span style="font-size:22px;color:black">{{ $ufield->label }}</span>
            </div>
            <div class="col-md-5">            
            <input type="text" class="form-control dropskill" name="{{'skill_'.$i}}" style="font-size:22px" value="{{ $ufield->placeholder }}"  />
            </div>
          </div>
          <?php $i++ ?>
          @endif
          @endforeach
          <input type="text" name="count" value="{{ $i }}" style="display:none">
                    <div class="clearfix"></div>
          <br>
 
          <input type="button" id="btnDone" class="btn btn-primary btn-lg pull-right" value="Done" />
        </form>
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
          <br>
          <br>
          <div id="successDiv" style="display:none">
          <p> Would you like to request recommendations on <span class="leftoutskills"></span> from former colleagues and supervisors?
            <ul>
            <li>Yes, I want to request them and then finish applying. <a href="{{ URL::route('new/form') }}">[Go to request]</a></li>
            <li> No, I am finished with the application. <a href="{{ route('skillcopysuccess',$uniqueform->unique_id) }}">[Continue]</a></li>
              </ul>
          </p>  
          </div>
          <div id="successDivComplete" style="display:none">
           I am finished with the application. <a href="{{ route('skillcopysuccess',$uniqueform->unique_id) }}">[Continue]</a>
            
          </p>  
          </div>
        </div>
      </div>
          
    </div>
        @endif
        </td>
        </tr>
      </table>
      <ul id="draggable" style="float:left;list-style:none">
       
          @foreach($fields as $f)
          @if($f->type == 'skill')
            <li data-code="{{ $f->unique_id }}" > <h2 style="display:inline-block"> <b>{{ $f->label }}</b> </h2>
            &nbsp;&nbsp;&nbsp; <h2 style="display:inline-block;margin-left:100px;"> <p class="code ui-widget-content"> {{ $f->unique_id }} </p> </h2>
           </li>
          @endif
          @endforeach
        
      </ul>
         <div class="clearfix"></div>
         <br>
      <table width="50%" id="skillshow" style="clear:float">
        <tr>
          <td>
           <strong style="font-size:19px">Writer</strong>: <code style="font-size:19px" id="writer_name"></code>
           <strong style="font-size:19px">Score</strong>: <code style="font-size:19px" id="ajaxscore"></code>
           <strong style="font-size:19px">year</strong>: <code style="font-size:19px" id="ajaxyear"></code>
          </td>
        </tr>
      </table>
     
      </div>
      <br>
      <div class="clearfix"></div>


      <div class="col-lg-6 padded panel panel-default range-div">
       <div class="slider-container padded">
        
        <h3>Dial to Weight</h3><hr><br><p>
        [Professional-Academic-Personal]
      </p>

      <br>
      0<div class="slider-range"></div><span class="pull-right">100</span>
    </div>
    <span class="slider-range-amount col-lg-offset-5 center-block"></span>
    <a href="" data-update="90" id="btn-redraw" class="btn btn-lg btn-primary pull-right">Redraw</a>
  </div>
  
  <div class="col-lg-6 padded panel panel-default range-div">

    <div class="padded">
      

      <div class="form-group form-group-sm">
        
        <label class="control-label" for="formGroupInputSmall">Professional</label>
        <div class="">
          <input type="text" class="form-control" readonly="true" id="prof" value="33"></input>
        </div>

      </div>
      
      <div class="form-group cleafix form-group-sm">

        <label class="control-label" for="formGroupInputSmall">Academic</label>
        <div class="">
          <input type="text" class="form-control" readonly="true" id="aca" value="33"></input>
        </div>

      </div>
      
      <div class="form-group cleafix form-group-sm">

        <label class="control-label" for="formGroupInputSmall">Personal</label>
        
        <div class="">
          <input type="text" readonly="true" class="form-control" id="pers" value="33"></input>            
        </div>

      </div>
      

    </div>  <!--padded-->

  </div>  <!--col-lg-6 panel-->

  <br>
  <br>
  <br>
  <!-- set up the modal to start hidden and fade in and out -->
  <div id="skillModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- dialog body -->
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         <strong style="font-size=19px">Writer</strong>: <code style="font-size=19px" id="writer_name"></code>
         <strong style="font-size=19px">Score</strong>: <code style="font-size=19px" id="ajaxscore"></code>
         <strong style="font-size=19px">year</strong>: <code style="font-size=19px" id="ajaxyear"></code>
        </div>
        <!-- dialog buttons -->
        <div class="modal-footer"><button type="button" class="btn btn-primary">OK</button></div>
      </div>
    </div>
  </div> 
  <script type="text/javascript">
    var baseUrl = '{{ URL::to("/") }}';
  </script>
  @if(isset($uniqueform))
  <script type="text/javascript">
    var job_form_id = '{{ $uniqueform->id }}';
  </script>
  @endif
  @stop
