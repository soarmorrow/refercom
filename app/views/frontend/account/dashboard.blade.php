@extends('frontend/layouts/default')

@section('css')
<link href="{{URL::asset('assets/css/timeline.css')}}" media="all" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/tooltipster.css')}}" media="all" rel="stylesheet" type="text/css" />
<style type="text/css">
  .blue{
    background-color: blue !important;
  }
</style>
@stop

@section('js')
<script src="{{URL::asset('assets/js/timeline-linkedin.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('assets/js/jquery.tooltipster.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">

var linkedin = {{ json_encode($linkedin) }};
var requests = {{ $requests }};
var seeker   = {{ json_encode($seeker) }}; 
var dates    = {{ json_encode($dates) }};
var requestids    = {{ json_encode($requestids) }};

var baseUrl = '{{ URL::to("/") }}';
</script>
<script type="text/javascript">

 if (!String.prototype.contains) {
    String.prototype.contains = function(s) {
      return this.indexOf(s) > -1
    }
  }


        $(function(){
          
        
        console.log(seeker);
        var timeline;
        var data=[];
        var count=0;

       
         var pusharr = {};
         
        for (var i = 0; i <= linkedin['positions']['_total']-1; i++) {
        	
        	console.log(linkedin['positions']['values'][i]['company']['name']);
        	console.log(linkedin['positions']['values'][i]['isCurrent']);
            console.log(linkedin['positions']['values'][i]['startDate']['month']);
            var arr = {};

            if(linkedin['positions']['values'][i]['isCurrent'])
            {
             arr['start']=new Date(linkedin['positions']['values'][i]['startDate']['year'],linkedin['positions']['values'][i]['startDate']['month']-1);
             arr['content']='<strong>Company</strong><br class="company">'+linkedin['positions']['values'][i]['company']['name'];
             var d = new Date();
             var month = d.getMonth();
             var year = d.getUTCFullYear(); 
             arr['end']=new Date(year,month);

             if(dates[i] != null || dates[i] == 'undefined')
             {

              if(dates[i]['know_from']['year'] >= linkedin['positions']['values'][i]['startDate']['year'])
              {
              
                 arr['className']= 'bg-info';
                 arr['content'] +=';'+requestids[i];
                 count++;
            
             }
           }
           
         }
         else
         {
           arr['start']= new Date(linkedin['positions']['values'][i]['startDate']['year'],linkedin['positions']['values'][i]['startDate']['month']-1);
           arr['end']= new Date(linkedin['positions']['values'][i]['endDate']['year'],linkedin['positions']['values'][i]['endDate']['month']);
           arr['content']='<strong>Company</strong><br class="company">'+linkedin['positions']['values'][i]['company']['name'];
           
           if(dates[i] != null || dates[i] == 'undefined')
           {

             if(dates[i]['know_from']['year'] >= linkedin['positions']['values'][i]['startDate']['year'])
             {
              if(dates[i]['know_from']['year'] <= linkedin['positions']['values'][i]['endDate']['year'])
              {

               arr['className'] = 'bg-info';
               arr['content'] +=';'+requestids[i];
               count++;
             }
           }
         }

       }

      
           console.log(arr);
             data.push(arr);
          console.log(data);



        };

        if(linkedin['educations'] != null){
          for (var i = 0; i <= linkedin['educations']['_total']-1; i++) {
           var arr = {};
           arr['start']= new Date(linkedin['educations']['values'][i]['startDate']['year'],0);
           arr['end']= new Date(linkedin['educations']['values'][i]['endDate']['year'],0);
           arr['content']='<strong class="letter_type_edu">Education</strong><br><strong>Degree:</strong>'+linkedin['educations']['values'][i]['degree']+'<br><strong>fieldOfStudy:</strong>'+linkedin['educations']['values'][i]['fieldOfStudy']+'<br><strong>Institution:</strong><br class="company">'+linkedin['educations']['values'][i]['schoolName']+'';
           

           if(dates[i] != null || dates[i] == 'undefined')
           {

             if(dates[i]['know_from']['year'] >= linkedin['educations']['values'][i]['startDate']['year'])
             {
              if(dates[i]['know_from']['year'] <= linkedin['educations']['values'][i]['endDate']['year'])
              {
               arr['className'] = 'bg-info';
               arr['content'] +=';'+requestids[i];
               count++;
             }
           }
         }

           console.log(arr);
           data.push(arr);
           console.log(data);

         };

       }


        console.log('testing');
        console.log(data.length);
        var perc = (count/data.length)*100;
       
        if(perc == 100)
        {
          location.href = '{{route("timeline") }}';
        }

        $('#profile_perc').text(' your Profile is '+perc.toFixed(2)+' % complete');

        console.log(data);

            // specify options
            var options = {
                'width':  '100%',
                'height': '500px',
                'editable': false,   // enable dragging and editing events
                'style': 'box',
                'showCurrentTime':false,
                'cluster':true
            };

            // Instantiate our timeline object.
            timeline = new links.Timeline(document.getElementById('mytimeline'), options);

            function onRangeChanged(properties) {
                document.getElementById('info').innerHTML += 'rangechanged ' +
                        properties.start + ' - ' + properties.end + '<br>';
            }
            
            //onselect event
            function onselect() {
                var sel = timeline.getSelection();


            
                var item = timeline.getItem(sel[0].row);
                console.log(item.content);
                console.log(item.start);
                console.log(item.end);
                $('.timeline-event-selected-before').remove();
                 var x = new Date(item.start);
                 var y = new Date(item.end);
                var startdate = (x.getUTCMonth()+1)+"-"+x.getUTCFullYear();
                var enddate   = (y.getUTCMonth()+1)+"-"+y.getUTCFullYear();

                $('.timeline-event-selected').prepend('<span class="timeline-event-selected-before"><strong>Company</strong><br>'+item.content+'<br>'+startdate+'<br>'+enddate+'</span>');

              
                // </span class="timeline-event-selected-before">'+item.content+'<br>'+item.start+'<br>'+item.end+'</span>
           //      if (sel.length) {
           //          console.log(sel.length);
           //          console.log(sel[0]);
           //          if(sel[0] != undefined)
           //          {
           //              if (sel[0].row != undefined) {
           //                  var row = sel[0].row;
           //              // alert("event " + row + " selected");
           //          }
           //          else {
           //             $('.timeline-event-selected-before').remove();
           //         }
           //     }
           // }
     }
     function getSelectedRow() {
        var row = undefined;
        var sel = timeline.getSelection();
        if (sel.length) {
            if (sel[0].row != undefined) {
                row = sel[0].row;
            }
        }
        return row;
    }

      var onselect = function (event) {
            var row = getSelectedRow();

            if (row != undefined) {
                //document.getElementById("info").innerHTML += "item " + row + " selected<br>";
                // Note: you can retrieve the contents of the selected row with
                // data.getValue(row, 2);
                var sel = timeline.getSelection();
             
                var item = timeline.getItem(sel[0].row);
                console.log(item.content);
                console.log(item.start);
                console.log(item.end);

                
                 

                var x = new Date(item.start);
                var y = new Date(item.end);
                var startdate = (x.getUTCMonth()+1)+"-"+x.getUTCFullYear();
                var enddate   = (y.getUTCMonth()+1)+"-"+y.getUTCFullYear();

                var company = item.content.split('<br class="company">')[1];
                var letter_type = 'Professional';
                


                if(item.content.contains('letter_type_edu')){
                    letter_type = 'Academic';                                        
                }

                var url = '{{ route("postLinkedinForm", array(":company",":letter_type") ) }}';
                url = url.replace(':company', company);
                url = url.replace(':letter_type', letter_type);

               
                
                if($('.timeline-event-selected').hasClass("bg-info"))
                {
                  $('.timeline-event-selected-before').remove();

                   var pdfurl = '{{ route("pdf/submission", ":requestid") }}';
                   pdfurl = pdfurl.replace(':requestid',item.content.split(';')[1]);

                   var skillurl = '{{ route("skillranking", ":requestid") }}';
                   skillurl = skillurl.replace(':requestid',item.content.split(';')[1]);
                   
                   var ajaxdata="requestid="+item.content.split(';')[1];
                   var seeker_fname="";
                   var seeker_lname=""; 
                   $.ajax({
                    url: baseUrl+'/ajax/get-seeker',
                    method:'post',
                    data: ajaxdata,
                    success: function(data){
                      if(data.status=="success")
                      {
                        seeker_fname = data.first_name;
                        seeker_lname = data.last_name;
                         $('.timeline-event-selected').prepend('<span class="timeline-event-selected-before">&nbsp;Recommended by <br><a href="'+pdfurl+'">'+seeker_fname+' '+seeker_lname+' </a><a href="'+skillurl+'">(See Skills)</a></span>');
                        
                      }
                      else
                      {

                       
                      }
                    },
                    dataType: 'json'
                  });


                 
                
                }
                else
                {
                  $('.timeline-event-selected-before').remove();
                  $('.timeline-event-selected').prepend('<span class="timeline-event-selected-before">&nbsp;'+item.content+'<br><strong>Start Date</strong>:&nbsp;'+startdate+'<br><strong>End Date</strong>:&nbsp;'+enddate+'<br><br><p align="center"><a href="'+url+'" id="btnGetRecommend" class="btn btn-xs btn-success">get recommended</a></p></span>');
                }
                
            }
            else {
                 $('.timeline-event-selected-before').remove();
            }
        };

           

            // attach event listener using the links events handler
            links.events.addListener(timeline, 'rangechanged', onRangeChanged);
            links.events.addListener(timeline, 'select', onselect);

            // Draw our timeline with the created data and options
            timeline.draw(data);
        // }
    });
    </script>

@stop

@section('content')
<div class="page-title">
	<h1>
		Dashboard
	</h1>
</div>
<!-- Notifications -->
@include('frontend/notifications')
<div class="clearfix"></div>
<div class="row">
	<div class="widget-container fluid-height clearfix container-fluid">
		
		<div class="widget-content padded">
           
			
			<div class="clearfix"></div>
            <br>
			<div id="mytimeline"></div>
            
            <div class="clearfix"></div>
            <br>
            <div align="center">
              <span><b>Note:</b></span><span class="text-danger" id="profile_perc"></span>
              <a href="{{ route('timeline') }}" class="btn btn-primary">I'm done</a>
            </div>

            <div style="display:none" id="info"></div>
		</div>
	</div>
</div>
@stop