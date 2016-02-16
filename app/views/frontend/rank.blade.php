@extends('frontend/layouts/default')



@section('css')
  <link href="{{URL::asset('assets/conrolfrog/css/controlfrog.css')}}" media="all" rel="stylesheet" type="text/css" />
  <link href="{{URL::asset('assets/css/star-rating.min.css')}}" rel="stylesheet">
  <style type="text/css">
  .cf-item{

  
  }
  </style>
   
@stop
@section('js')

 
  <script src="{{URL::asset('assets/conrolfrog/js/moment.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/easypiechart.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/gauge.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/chart.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/jquery.sparklines.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/conrolfrog/js/controlfrog-plugins.js')}}" type="text/javascript"></script>
 <script src="{{URL::asset('assets/js/star-rating.min.js')}}"></script>
<script>
    $(function () {
      var c=1;
       $("#input-rating").rating();
       $( "[id^='slider-range-min-']" ).slider({
        range: "min",
        value: 5,
        min: 1,
        max: 5,
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
      
    
    });

</script>

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
var funSkill=[];
var funTitle=[];
var funRank=[]
var funTitleYears=[];
var i=0;
var j=0;
var p=0;
var r=0;
var s=0;
var d=0;
var x=0;
var arr = [];

$(document).ready(function(){
	/*
	*	Copy the each() function for each Funnel chart you have
	* 	e.g. $('#cf-funnel-1').each(function(){.....}
	*/
    
    /*
    *  skills
    */

   

    $('.skill').each(function(){

          funSkill.push($(this).html());
   
    });
    console.log(funSkill);
     console.log(funSkill.length);
    
     /*
    *  skills
    */
    $('.users').each(function(){

        funLabels.push($(this).html());

    });
    console.log(funLabels);

     /*
    *  score iterated and stored to Data[skill]
    */
    $('.score').each(function(){
          

        console.log(parseInt($(this).html()));
        if(funSkill[1] ==null )
        {
            console.log(funSkill[1]);
            funData.push(parseInt($(this).html()));
        }
        else
        {
            //arr[d] = (parseInt($(this).html()));
            console.log(funData);
         
           // funData[d][funSkill[i]] = (parseInt($(this).html()));
        
            console.log((funData).toString()); 
        }
        if(i==funSkill.length-1)
        {
            i=0;
            d++;
        }
        else
        {
            i++;
        }

      
    });

    console.log(funData);

     /*
    *  years 
    */

    $('.years').each(function(){

        if(funSkill[1] == null)
        {

            funYears.push(parseInt($(this).html()));
        }
        else
        {

           // funYears[funSkill[j]][x] = (parseInt($(this).html()));

        }
         if(i==funSkill.length-1)
        {
        j=0;
        x++;
        }
        else
        {
            j++;
        }

    });
    console.log(funYears);
    
     /*
    * chart title
    */    
    $('.title').each(function(){

    funTitle[funSkill[r]] = $(this).html();
        r++;

    });
    console.log(funTitle);
    
     /*
    *  years
    */
    $('.titleyears').each(function(){

    funTitleYears[funSkill[s]] = $(this).html();
        s++;

    });
    console.log(funTitleYears);
    
     /*
    *  relation
    */
    $('.relation').each(function(){

        funRelation.push($(this).html());
    });
    console.log(funRelation);
    
     /*
    *  writers
    */
    $('.writers').each(function(){

        funWriter.push($(this).html());
    });
    console.log(funWriter);
    
     /*
    *  organisation
    */
    $('.organisation').each(function(){

        funOrganisation.push($(this).html());
    });
    console.log(funOrganisation);

    /*
    *  rank
    */
    $('.ranks').each(function(){

        funRank.push($(this).html());
    });
    console.log(funRank);
    
     /*
    *  users
    */
    $('.users').each(function(i,a){

        label[i]=funLabels[i]+'<span style="display:none">->ranked by '+funWriter[i]+', '+funRelation[i]+' at '+funOrganisation[i]+'</span>';
    });


	$('.container-star').each(function(){
        console.log(p);
        // console.log(Data[p][funSkill[p]]);
        var funYear = [];
        var funDat =[];
        var sc=[];
        var yr=[];
        var a=0;
        var b=0;
    console.log('#container'+funSkill[p]);
 
   
    console.log(funYears);
    console.log(funData);
    console.log(label);

   if(funSkill[1] == null)
   {

     funData.forEach(function(g){
      console.log(g);
       funDat.push(g);
       a++;
     });
     funYears.forEach(function(f){

        funYear.push(f)
     b++;
     });
   
   }
   else
   {
       Data[p][funSkill[p]].forEach(function(g){

        funDat.push(g);
   });
    Year[p][funSkill[p]].forEach(function(g){

        funYear.push(g);
   });
   }

  

   console.log(funYear);
    console.log(funDat);
    
	$('#container'+funSkill[p]).highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: funTitle[funSkill[p]].toString()
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
            data: funYear,
            color:'#ff943a'
        },
         {
            name: 'score',
            data: funDat
            
        }]
    });

      $('#containerScore'+funSkill[p]).highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: funTitle[funSkill[p]].toString()
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
            data: funDat
        },]
    });

 $('#containerYears'+funSkill[p]).highcharts({
        chart: {
            type: 'bar'
        },
        title: {
            text: funTitleYears[funSkill[p]].toString()
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
            data: funYear
        },]
    });
  p++;
});

   //R code

var chartOptions = {
        chart: {
            type: 'scatter',
            zoomType: 'xy'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            title: {
                enabled: true,
                text: 'Rank (total)'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },
        yAxis: {
            title: {
                text: 'Year (total)'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 100,
            y: 70,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
            borderWidth: 1
        },
        plotOptions: {
            scatter: {
                marker: {
                    radius: 5,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x} , {point.y} '
                }
            }
        },
        series: [{
            name: 'Supervisor',
            color: 'rgba(223, 83, 83, .5)',
            data: supRank

        }, {
            name: 'other',
            color: 'rgba(119, 152, 191, .5)',
            data: otherRank
        }]
    };
   $('#containerS').highcharts(chartOptions);

var NewChartOptions=chartOptions;
var NewData=[];
$('#btnRedraw').click(function(){
    
@foreach($fields as $f)
@if ($f->type === 'skill')

var z=0;     
     filterRank['{{$f->label}}'].forEach(function(a){
         console.log(a[0].toString());
         if(a[0] <= $('.{{$f->label}}').val())
            {
                NewData.push(fRank[z]);
                console.log(NewData);
              
           }
            z++;

     });


@endif
@endforeach
   
   NewChartOptions['series']=[{
            name: 'All',
            color: 'rgba(223, 83, 83, .5)',
            data: NewData
            }];
    
   $('#containerS').highcharts(NewChartOptions);    

  return false;
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
         
          <p style="display:none"  class="score">{{$op*2}}<p>
          @else
          <p style="display:none" class="years">{{$op}}</p>
          @endif

	   <?php   $i++; ?>
	      @endforeach
	      @endforeach
        @endif

        @endforeach

        <script type="text/javascript">
        var Data = [
            <?php   $i=1; ?>
            @foreach($fields as $f)
                @if ($f->type === 'skill')
                    {
                        '{{ $f->label }}': [
                            @foreach($f->submission()->get() as $f1)
                                @foreach(json_decode($f1->option) as $op) 
                                
                                  @if($i==1 || $i % 2 !=0)
                                    {{$op}} ,
                                  @endif

                                  <?php   $i++; ?>

                                @endforeach 
                            @endforeach
                        ],
                    },
                @endif
            @endforeach
            ];

        var Year = [
            <?php   $i=1; ?>
            @foreach($fields as $f)
                @if ($f->type === 'skill')
                    {
                        '{{ $f->label }}': [
                            @foreach($f->submission()->get() as $f1)
                                @foreach(json_decode($f1->option) as $op) 
                                
                                  @if($i!=1 && $i % 2 ==0)
                                    {{$op}} ,
                                  @endif

                                  <?php   $i++; ?>

                                @endforeach 
                            @endforeach
                        ],
                    },
                @endif
            @endforeach
            ];

            <?php $rank = array(); 
                foreach($fields as $f){
                    if ($f->type === 'skill'){
                        $j = 0;
                        
                        foreach($f->submission()->get() as $f1){

                            if(empty($rank[$j])){
                                $rank[$j]['rank'] = 0;
                                $rank[$j]['year'] = 0;
                            }

                            $type = $f1->request()->first()->relationship;
                            if($type != 'supervisor')
                                $type = 'Other';

                            $rank[$j]['type'] = $type;

                            $i = 1;
                            foreach(json_decode($f1->option) as $op) {
                                
                                if($i==1 || $i % 2 !=0)
                                    $rank[$j]['rank'] += (int)$op; 
                                else
                                    $rank[$j]['year'] += (int)$op;

                                $i++; 
                            }

                            $j++;

                        }
                    }
                }
            ?>

             <?php $rankr = array(); 
                foreach($fields as $f){
                    if ($f->type === 'skill'){
                        $j = 0;
                        
                        foreach($f->submission()->get() as $f1){

                            if(empty($rankr[$j][$f->label])){
                                $rankr[$f->label][$j]['rank'] = "";
                                $rankr[$f->label][$j]['year'] = "";
                                 $rankr[$f->label][$j]['type'] = "";
                            }

                            $type = $f1->request()->first()->relationship;
                            if($type != 'supervisor')
                                $type = 'Other';

                            $rankr[$f->label][$j]['type'] = $type;

                            $i = 1;
                            foreach(json_decode($f1->option) as $op) {
                                
                                if($i==1 || $i % 2 !=0)
                                    $rankr[$f->label][$j]['rank'] .= (int)$op.','; 
                                else
                                    $rankr[$f->label][$j]['year'] .= (int)$op.'';

                                $i++; 
                            }

                            $j++;

                        }
                    }
                }
            ?>

             var supRank = [
                <?php foreach($rank as $r){
                    if($r['type'] == 'supervisor')
                        echo '['.$r['rank'].','.$r['year'].'],';
                }?>
                        ];
            var otherRank = [
                <?php foreach($rank as $r){
                    if($r['type'] != 'supervisor')
                        echo '['.$r['rank'].','.$r['year'].'],';
                }?>
                        ];
                var fRank = [
                <?php foreach($rank as $r){
                        echo '['.$r['rank'].','.$r['year'].'],';
                }?>
                  
                        ];
             <?php $filterRank = " ";
             foreach($rankr as $r => $value)
                {
                    $filterRank .= $r.':[';
                    foreach($value as $v){
                              
                             $filterRank.= '['.$v['rank'].''.$v['year'].'],';  
                      }
                     $filterRank= rtrim($filterRank, ",");

                    $filterRank.= "],";
                } $filterRank= rtrim($filterRank, ",");  ?>  

                var filterRank={
                    {{$filterRank}}
                };
        

        </script>

  @foreach($seeker as $s)
          <p style="display:none"  class="users">{{$s->first_name}}<p>
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

<?php   $i=1; ?>

     @foreach($fields as $f)
       @if ($f->type === 'skill')
  


 <span style="display:none" class="skill">{{$f->label}}</span>

  <div id="containerScore{{$f->label}}"  style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<div id="containerYears{{$f->label}}" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

<div id="container{{$f->label}}" class="container-star" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

 <span style="display:none" class="title">{{$f->label}} score rank comparison (score)</span>
<span style="display:none" class="titleyears">{{$f->label}} score rank comparison (years)</span>
     @endif
<?php $i++ ?>
        @endforeach









@if($organization)
<?php $i=1 ?>
<div id="containerS" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
@foreach($fields as $f)
@if ($f->type === 'skill')
<div class="well padded col-md-5">
{{$f->label}}
<div class="col-sm-7">
    <p><input type="text" id="amount-{{$i}}"  class="amount {{$f->label}}" readonly name="name_{{ $f->id }}[]" style="border:0; color:#f6931f; font-weight:bold;"></p>
    <div id="slider-range-min-{{$i}}"></div>
</div>
</div>
<div class="clearfix"></div>
<br>
@endif
<?php $i++ ?>
@endforeach
 <a href="" id="btnRedraw" class="btn btn-large btn-success">Redraw</a>
@endif

@stop