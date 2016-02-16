


  var ops=[];
  var vals=[];



  if (!String.prototype.contains) {
    String.prototype.contains = function(s) {
      return this.indexOf(s) > -1
    }
  }


  $(function(){

// clear the droparea

    $('#target').empty();
    $('#target').html('');


// hide both form save and saving.. gif image  
    $('.saving-show').hide();
    $('.final-save').hide();
    

    
    console.log(formfields);
    var g=0;
    formfields.forEach(function(f) {
     
     if(f['type']=='skill')
     {

       w=1
       console.log(f['type']);
       $('#target').append('<div class="form-group"><legend>Skills:</legend><div class="form-group"><!-- Rating --><!-- skill --><label class="col-sm-4 control-label" for="rating">'+f['label']+'</label><div class="col-sm-7"><input id="input-rating" name="rating" value="4" type="text" class="rating form-control rating-skill" placeholder="placeholder" min=0 max=5 step=0.2 data-size="xs"><br></div></div><div class="form-group"><!-- percentage --><label class="control-label col-md-2">'+f["label"]+'</label><div class="col-sm-7"><p><input type="text" id="amount-'+g+'" name="percentage" class="amount perc-skill" readonly  style="border:0; color:#f6931f; font-weight:bold;"></p><div id="slider-range-min-'+w+'"></div></div></div></div>');
       
       var c=1;
       $("#input-rating").rating();
       $( "[id^='slider-range-min-']" ).slider({
        range: "min",
        value: 37,
        min: 1,
        max: 100,
        slide: function( event, ui ) {
              // console.log(event);
              var id= event.target.attributes['id'].value;
             // console.log(typeof(id));
             // console.log(id);
             c=id.toString().split('-');
             // console.log(c[3]);
             $( "#amount-"+c[3] ).val( "" + ui.value );
           }
         });
       $sliders= $( "[id^='slider-range-min-']" );
           // for (var i =  1; i < $sliders.length; i++) {
           // console.log(c[3]);
           $( "#amount-"+c[3] ).val( "" + $( "#slider-range-min-"+c[3] ).slider( "value" ) ); 

         }
         //------percentage----
         if(f['type']=='percentage')
         {
          g=1
          console.log(f['type']);
          $('#target').append('<div class="form-group"><!-- percentage --><label class="control-label col-md-2">'+f["label"]+'</label><div class="col-sm-7"><p><input type="text" id="amount-'+g+'" name="percentage" class="amount" readonly  style="border:0; color:#f6931f; font-weight:bold;"></p><div id="slider-range-min-'+g+'"></div></div></div>');


          var c=1;
          $("#input-rating").rating();
          $( "[id^='slider-range-min-']" ).slider({
            range: "min",
            value: 37,
            min: 1,
            max: 100,
            slide: function( event, ui ) {
              // console.log(event);
              var id= event.target.attributes['id'].value;
             // console.log(typeof(id));
             // console.log(id);
             c=id.toString().split('-');
             // console.log(c[3]);
             $( "#amount-"+c[3] ).val( "" + ui.value );
           }
         });
          $sliders= $( "[id^='slider-range-min-']" );
           // for (var i =  1; i < $sliders.length; i++) {
           // console.log(c[3]);
           $( "#amount-"+c[3] ).val( "" + $( "#slider-range-min-"+c[3] ).slider( "value" ) ); 


         }
         //------rating----/
         if(f['type']=='rating')
         {
          $('#target').append('<div class="form-group"><!-- Rating --><label class="col-sm-4 control-label" for="rating">'+f['label']+'</label><div class="col-sm-7"><input id="input-rating" name="rating" value="4" type="text" class="rating form-control" placeholder="placeholder" min=0 max=5 step=0.2 data-size="xs"><br></div></div>');
          $("#input-rating").rating();
        }
        if(f['type']=='textfield')
        {
          $('#target').append('<div class="form-group"><!-- Text input --><label class="col-sm-4 control-label" for="textInput">'+f["label"]+'</label><div class="col-sm-7"><input id="textInput" name="textInput" type="text" placeholder="'+f["placeholder"]+'" class="form-control"><br></div></div>');
          
        }
        if(f['type']=='textarea')
        {
          $('#target').append('<div class="form-group"><!-- Textarea --><label class="col-sm-4 control-label" for="textarea">'+f["label"]+'</label><div class="col-sm-7"><div class="input-group"><textarea id="textarea" name="textarea" class="form-control">'+f["placeholder"]+'</textarea></div><br></div></div>');
          
        }
        if(f['type']=='dropdown')
        {
         var ops="";
             // f['options'].toArray().forEach(function(op) {
              var result = $.parseJSON(f['options']);
              console.log(result);
              $.each(result, function(k, v) {
                //display the key and value pair
                $.map(v, function(value, index){
                  console.log(k, value, index);
                  ops += '<option value="'+value+'">'+index+'</option>';
                });
              });
              
              $('#target').append('<div class="form-group"><!-- Select multiple --><label class="col-sm-4 control-label" for="selectSingle">'+f["label"]+'</label><div class="col-sm-7"><select id="selectMultiple" name="selectMultiple" class="form-control" >'+ops+'</select></div></div>');
              


            }
            if(f['type']=='multiselect')
            {
             var ops="";
             // f['options'].toArray().forEach(function(op) {
              var result = $.parseJSON(f['options']);
              console.log(result);
              $.each(result, function(k, v) {
                //display the key and value pair
                $.map(v, function(value, index){
                  console.log(k, value, index);
                  ops += '<option value="'+value+'">'+index+'</option>';
                });
              });
              
              $('#target').append('<div class="form-group"><!-- Select multiple --><label class="col-sm-4 control-label" for="selectMultiple">'+f["label"]+'</label><div class="col-sm-7"><select id="selectMultiple" name="selectMultiple" class="form-control"  multiple="multiple">'+ops+'</select></div></div>');
              


            }
            if(f['type']=='checkbox')
            {
             var ops="";
             // f['options'].toArray().forEach(function(op) {
              var result = $.parseJSON(f['options']);
              console.log(result);
              $.each(result, function(k, v) {
                //display the key and value pair
                $.map(v, function(value, index){
                  console.log(k, value, index);
                  ops += '<label class="checkbox" for="checkboxes"><input type="checkbox" name="checkboxes" id="checkboxes-0" value="'+value+'" checked="checked">'+index+'</label>';
                });
              });
              
              $('#target').append('<div class="form-group"><!-- Multiple checkboxes --><label class="col-sm-4 control-label" for="textInput">'+f['label']+'</label><div class="col-sm-7">'+ops+'</div></div>');
              


            }
            if(f['type']=='radiobutton')
            {
             var ops="";
             // f['options'].toArray().forEach(function(op) {
              var result = $.parseJSON(f['options']);
              console.log(result);
              $.each(result, function(k, v) {
                //display the key and value pair
                $.map(v, function(value, index){
                  console.log(k, value, index);
                  ops += '<label class="radio" for="radios"><input type="radio" name="radios" id="radios-0" value="'+value+'" checked="checked">'+index+'</label>';
                });
              });
              
              $('#target').append('<div class="form-group"> <!-- Multiple radios --><label class="col-sm-4 control-label" for="textInput">radios</label><div class="col-sm-7">'+ops+'</div></div>');
              


            }
            


          });

$(".serialize").on('click',function(e){
  e.preventDefault();
  var d=0;
  
  $('.saving-show').show();
  console.log(form);

  if(d==0)
  {

   var p="";
   p += 'form='+form;
   $.ajax({
    url: baseUrl+'/account/ajax/formDelete',  
    method:'post',
    data: p,
    success: function(data){
     console.log(data.status);
     saveAction();
     
   },
   dataType: 'json'
 }); 
 }
 d++;
 console.log($("#targetForm").serialize());
 console.log($("#target").find('.form-group'));
 

 

 
});
});

function saveAction()
{

 var i=0;

 console.log($("#targetForm").serialize());
 $("#target").find('.form-group').each(function() {
             // console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);
             // console.log(($("#target").find('.form-group'))[i].children[1].children[0].attributes);
            //  console.log(($("#target").find('.form-group'))[i].children[1].innerHTML);
            
            
            if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('<input'))
            {
              if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('type="checkbox"'))
              {
                
                console.log('checkbox');
                console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);

                var op="";
                var vl="";
                var stri='';
                for(var j=0;j<($("#target").find('.form-group'))[i].children[1].childElementCount;j++)
                {

                  vl= ($("#target").find('.form-group'))[i].children[1].children[j].childNodes[0].attributes['value'].value;
                  op= ($("#target").find('.form-group'))[i].children[1].children[j].childNodes[1].data;

                  if(vl !="" || op !="")
                  {


                   stri += '&option[]='+ ($("#target").find('.form-group'))[i].children[1].children[j].childNodes[1].data;
                   stri +='&value[]='+($("#target").find('.form-group'))[i].children[1].children[j].childNodes[0].attributes['value'].value;
                 }

               }
               stri +='&label='+($("#target").find('.form-group'))[i].children[0].innerHTML;
               console.log(stri);
               postForm('checkbox',stri); 
               

             }


           }
           if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('<input') && !(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('checkbox')))
           {
             if(!($("#target").find('.form-group'))[i].children[1].innerHTML.contains('type="radio"'))
             {
               if(!($("#target").find('.form-group'))[i].children[1].innerHTML.contains('input-rating'))
               {
                 if(!($("#target").find('.form-group'))[i].children[1].innerHTML.contains('ui-slider') )
                 {
                  console.log('textbox');
                  console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);
                  
                  console.log(($("#target").find('.form-group'))[i].children[1].children[0].attributes['placeholder'].nodeValue);

                  var l=($("#target").find('.form-group'))[i].children[0].innerHTML;
                  var p=($("#target").find('.form-group'))[i].children[1].children[0].attributes['placeholder'].nodeValue;
                  var stri='label='+l+'&placeholder='+p;
                  postForm('textfield',stri);
                    //  console.log(($("#target").find('.form-group'))[i].children[1].innerHTML.find('name'));
                  }
                }
              }
            }
            
            if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('<input') && !(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('checkbox')))
            {
             if(!($("#target").find('.form-group'))[i].children[1].innerHTML.contains('type="radio"'))
             {
               if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('input-rating'))
               {
                console.log('rating');
                console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);
                
                    //console.log(($("#target").find('.form-group'))[i].children[1].children[0].attributes['placeholder'].nodeValue);

                    var l=($("#target").find('.form-group'))[i].children[0].innerHTML;
                  //  var p=($("#target").find('.form-group'))[i].children[1].children[0].attributes['placeholder'].nodeValue;
                  var stri='label='+l;
                  
                  if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('rating-skill'))
                  {
                    console.log('rating-skill');
                    if(l != 'Skills:')
                      postForm('skill',stri);

                  }
                  else
                  {
                    if(l != 'Skills:')
                     postForm('rating',stri); 
                 }


                 

                  //  console.log(($("#target").find('.form-group'))[i].children[1].innerHTML.find('name'));
                }
              }
            }
            if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('ui-slider') )
            {
             
              console.log('percentage');
              console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);

                 // console.log(($("#target").find('.form-group'))[i].children[1].children[0].children[0].innerHTML);

                 var l=($("#target").find('.form-group'))[i].children[0].innerHTML;
                 // var p=($("#target").find('.form-group'))[i].children[1].children[0].children[0].innerHTML;

                 var stri='label='+l;

                 if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('perc-skill') )
                 {
                  console.log('perc-skills');
                }
                else
                {

                 postForm('percentage',stri);
               }         
             }
             if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('<textarea') )
             {
               
              console.log('textarea');
              console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);

              console.log(($("#target").find('.form-group'))[i].children[1].children[0].children[0].innerHTML);

              var l=($("#target").find('.form-group'))[i].children[0].innerHTML;
              var p=($("#target").find('.form-group'))[i].children[1].children[0].children[0].innerHTML;

              var stri='label='+l+'&placeholder='+p+'&rows=3';
              postForm('textarea',stri);
              
            }
            if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('type="radio"') )
            {
             
              console.log('radio');
              console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);
              
              var op="";
              var vl="";
              var stri='';
              for(var j=0;j<($("#target").find('.form-group'))[i].children[1].childElementCount;j++)
              {
                
                vl= ($("#target").find('.form-group'))[i].children[1].children[j].childNodes[0].attributes['value'].value;
                op= ($("#target").find('.form-group'))[i].children[1].children[j].childNodes[1].data;
                
                if(vl !="" || op !="")
                {
                 
                  
                 stri += '&option[]='+ ($("#target").find('.form-group'))[i].children[1].children[j].childNodes[1].data;
                 stri +='&value[]='+($("#target").find('.form-group'))[i].children[1].children[j].childNodes[0].attributes['value'].value;
               }
               
             }
             stri +='&label='+($("#target").find('.form-group'))[i].children[0].innerHTML;
             console.log(stri);
             postForm('radio',stri);                             
           }
           //------------- Single Select---------/ 
           if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('<select') )
           {
             if(!($("#target").find('.form-group'))[i].children[1].innerHTML.contains('multiple="multiple"') )
             {
              console.log('dropdown');
              console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);
              console.log(($("#target").find('.form-group'))[i].children[1].children[0].childElementCount);
              var op="";
              var vl="";
              var stri='';
              for(var j=0;j<($("#target").find('.form-group'))[i].children[1].children[0].childElementCount;j++)
              {
               op =  ($("#target").find('.form-group'))[i].children[1].children[0][j].innerHTML;
               vl =  ($("#target").find('.form-group'))[i].children[1].children[0][j].attributes[0].value;
               if(vl !="" || op !="")
               {
                 stri += '&option[]='+ ($("#target").find('.form-group'))[i].children[1].children[0][j].innerHTML;
                 stri +='&value[]='+($("#target").find('.form-group'))[i].children[1].children[0][j].attributes[0].value;
               }
               
             }
             
             
             stri += '&label='+($("#target").find('.form-group'))[i].children[0].innerHTML; 

             postForm('dropdown',stri);    
           }     
         }
         //------------- Multi Select---------/
         if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('<select') )
         {
          
          if(($("#target").find('.form-group'))[i].children[1].innerHTML.contains('multiple="multiple"') )
          {
            console.log('multiselect');
            console.log(($("#target").find('.form-group'))[i].children[0].innerHTML);
            console.log(($("#target").find('.form-group'))[i].children[1].children[0].childElementCount);
            var op="";
            var vl="";
            var stri='';
            for(var j=0;j<($("#target").find('.form-group'))[i].children[1].children[0].childElementCount;j++)
            {
              
             op =  ($("#target").find('.form-group'))[i].children[1].children[0][j].innerHTML;
             vl =  ($("#target").find('.form-group'))[i].children[1].children[0][j].attributes[0].value;
             if(vl !="" || op !="")
             {
               
               stri += '&option[]='+ ($("#target").find('.form-group'))[i].children[1].children[0][j].innerHTML;
               stri +='&value[]='+($("#target").find('.form-group'))[i].children[1].children[0][j].attributes[0].value;
             }
             
           }
           
           console.log(stri);
           

           stri += '&label='+($("#target").find('.form-group'))[i].children[0].innerHTML; 

           
           postForm('multiselect',stri);    
         }     
       }
       i++;
     });


}

function postForm(id,l, f){
  var s="";

  var str =""; 

 // console.log(str);
 var ftype="";
 var label="";

 switch(id)
 {


  case "textfield": 
  ftype="textfield";
   // str=$(id).serialize();
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   console.log(str);
   break;
   case "skill": 
   ftype="skill";
   // str=$(id).serialize();
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   console.log(str);
   break;
   case "rating": 
   ftype="rating";
   // str=$(id).serialize();
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   console.log(str);
   break;
   case "percentage": 
   ftype="percentage";
   // str=$(id).serialize();
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   console.log(str);
   break;

   case "textarea":
   ftype="textarea";   
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   console.log(str);
   break;

   case "checkbox":
   ftype="checkbox";
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   break;      
   case "dropdown":
   ftype="dropdown";
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   break;   
   case "multiselect":
   ftype="multiselect";
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   break;   
   case "radio" :
   ftype="radiobutton";
   str=l;
   console.log(str);
   str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
   break;
   

 }


 $.ajax({
  url: baseUrl+'/account/ajax/form',  
  method:'post',
  data: str,
  success: function(data){
   console.log(data.status);
   if(data.status=="success")
   {

     console.log("ok");
     $('.modal').modal('hide');

     fields[data.id] = str;
     

     console.log(id);
     $('.final-save').show();
     $('.saving-show').hide();




   }
   else
   {
    console.log('f'); 
    console.log(data.errors.label); 

    $.each(data.errors, function (i, item) {
      console.log(item);
      $('#error').append(item);
    });


    

  }
},
dataType: 'json'
}); 

 return false;

}



