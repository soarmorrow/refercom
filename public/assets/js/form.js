function allowDrop(ev) {
    ev.preventDefault();
}
function allowDroparea(ev) {
    ev.preventDefault();
}

/*-----text box-----*/

function drag(ev) {
 
    ev.dataTransfer.setData("text/html", ev.target.id);
}

function drop(ev) {

    ev.preventDefault();
    var data = ev.dataTransfer.getData("text/html");
   // ev.target.appendChild(document.getElementById(data).cloneNode(true));
  


    var newfieldtf="";
    newfieldtf = '<div class="clearfix"></div><br/><div  id="divtf"><div class="col-md-6"><input type="text" class="form-control inline" placeholder="Text input"></div><button type="button" id="TfieldDelete" class="btn btn-danger tf inline">Delete</button></div><div class="clearfix"></div><br/>';
    $('#tab1').append(newfieldtf);

}


/*-----text area-----*/

function dragarea(ev) {
 
    ev.dataTransfer.setData("text/html", ev.target.id);
}

function droparea(ev) {

    ev.preventDefault();
    var data = ev.dataTransfer.getData("text/html");
   // ev.target.appendChild(document.getElementById(data).cloneNode(true));
  
    

    var newfield="";
    var rows=3;
    newfield = '<div class="clearfix"></div><br/><div  id="divta"><div class="col-md-6"><textarea rows="'+rows+'" type="text" class="form-control  inline" placeholder="Text input"></textarea></div><button type="button" id="TareaDelete" class="btn btn-danger ta inline">Delete</button></div><div class="clearfix"></div><br/>';
    $('#tab1').append(newfield);
}



var formName="form";
/*var fName="";
var desc="";

	var htmlName="";
	var htmlDesc="";
	*/
	window.fName="";
	window.desc="";
  var form_tab_id=0;
  var type="";

  var eName="",editDesc="";
  var flag=0;
  $(function() {

    $('#save').hide();
    $('#cancel').hide();

     $('#continueSubmit').prop('disabled', true);

    $( "#edit" ).click(function() {
     $('#save').show();
     $('#cancel').show();
     $(this).hide();

     var htmlName="";
     var htmlDesc="";

     window.fName=$('h3.form_title').text();
     window.desc=$('h4.form_desc').text();
     $('h3.form_title').text('');$('h3.form_desc').text('');
     console.log(window.fName,window.desc);

     htmlName = '<input type="text" class="form-control form_title eName" value="'+window.fName+'" name="name" /><br/><div class="clearfix"></div>';
     htmlDesc = '<input type="text" class="form-control form_desc eDesc" value="'+window.desc+'" name="name" /><br/><div class="clearfix"></div>';

     $('.editName').html(htmlName);
     $('.editDesc').html(htmlDesc);
   });

    $( "#cancel" ).click(function() {
     $('#save').hide();
     $(this).hide();
     $( "#edit" ).show();

     var	htmlName="";
     var	htmlDesc="";





     htmlName = '<h3 class="form_title" name="name" >'+window.fName+' </h3>';
     htmlDesc = '<h4 class="form_desc" name="name">'+window.desc+' </h4>';

     window.fName="";
     window.desc="";
     console.log(window.fName,window.desc);
     $('.editName').html(htmlName);
     $('.editDesc').html(htmlDesc);

   });

    $( "#save" ).click(function() {
     $(this).hide();
     $('#cancel').hide();
     $( "#edit" ).show();



     var	htmlName="";
     var	htmlDesc="";

     window.fName=$('input.form_title').val();
     window.desc=$('input.form_desc').val();
     var fname=window.fName;
     var desc=window.desc;
     htmlName = '<h3 class="form_title" name="name" >'+window.fName+' </h3>';
     htmlDesc = '<h4 class="form_desc" name="name">'+window.desc+' </h4>';
     var data="formName="+fname+"&description="+desc;
     $.ajax({
      url: baseUrl+'/account/ajax/name',
      method:'post',
      data: data+'&form_id='+form,
      success: function(data){
        if(data.status=="success")
        {

          $('.editName').html(htmlName);
          $('.editDesc').html(htmlDesc);
        }
        else
        {

          $('.errorMsg').html('An error occured!').show();
        }
      },
      dataType: 'json'
    });
     
     window.fName="";
     window.desc="";

     return false;
   });
  
    $( "#saveForm" ).click(function() {

     var data="status=active";
     $.ajax({
      url: baseUrl+'/account/ajax/saveForm',
      method:'post',
      data: data+'&form_id='+form,
      success: function(data){
        if(data.status=="success")
        {
          console.log('s');
         $('.successMsg').html('successfully saved').show();
         $('#continueSubmit').prop('disabled', false);

         $('#uniqueDiv p').text(unique_id);
       }
       else
       {

        $('.errorMsg').html('An error occured!').show();
      }
    },
    dataType: 'json'
  });
     


     return false;
   });

function postForm(id){
  var s="";


  var str =""; 

  console.log(str);
  var ftype="";
  var label="";

  switch(id)
  {


    case "#formtextField": 
    ftype="textfield";
    str=$(id).serialize();
    str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
    break;

    case "#formtextArea":
    ftype="textarea";   
    str=$(id).serialize();
    str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
    break;

    case "#formcheckBox":
    ftype="checkbox";
    str=$(id).serialize();
    str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
    break;      
    case "#formDropDown":
    ftype="dropdown";
    str=$(id).serialize();
    str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
    break;   
    case "#formRadioButton" :
    ftype="radiobutton";
    str=$(id).serialize();
    str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
    break;
    case "#formHeadline": 
    ftype="headline";
    str=$(id).serialize();
    str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;
    break;
    case "#formParagraph": 
    ftype="paragraph"; 
    str=$(id).serialize(); 
    str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;      
    break;
    default: 
    ftype="line";
    label="line";
    str += '&form_tab_id='+0+'&type='+ftype+'&form='+form+'&label='+label;


  }

  str += '&form_tab_id='+0+'&type='+ftype+'&form='+form;

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

                 switch(id)
                 {


                  case "#formtextField": 

                  var newfieldtf="";
                  newfieldtf = '<div class="clearfix"></div><br/><div  id="divtf"><div class="col-md-6"><input type="text" class="form-control inline" placeholder="Text input"></div><button type="button" id="TfieldDelete" class="btn btn-danger tf inline">Delete</button></div><div class="clearfix"></div><br/>';
                  $('#tab1').append(newfieldtf);
                  break;

                  case "#formtextArea":

                  var newfield="";

                  var rows="";

                  rows=$('#inputRows').val();
                  newfield = '<div class="clearfix"></div><br/><div  id="divta"><div class="col-md-6"><textarea rows="'+rows+'" type="text" class="form-control  inline" placeholder="Text input"></textarea></div><button type="button" id="TareaDelete" class="btn btn-danger ta inline">Delete</button></div><div class="clearfix"></div><br/>';

                  $('#tab1').append(newfield);
                  break;

                  case "#formcheckBox":
                  var newfieldCB="";
                  var name=[];
                  var value=[];

                  $(".optionC").each(function() {

                   name.push($(this).val());
                 });

                  value="";
                  for(var i = 0 ; i < name.length ; i++){

                    newfieldCB = '<div class="clearfix"></div><br/><div  id="divcb"><div class="col-md-3"><div class="checkbox-inline"><label><input type="checkbox" value="'+value[i]+'">'+name[i]+'</label></div></div><button type="button" id="CboxDelete" class="btn btn-danger cb inline">Delete</button></div>';
                    $('#tab1').append(newfieldCB);

                  }
                  break;      
                  case "#formDropDown":

                  var newfieldDD="";
                  var name=[];
                  var value=[];

                  $(".optionD").each(function() {
                    console.log($(this).val());
                    name.push($(this).val());
                  });

                  value="";
                  var newf='<div class="" id="divDD"><div class="col-md-9 inline"><select class="form-control inline">';
                  for(var i = 0 ; i < name.length ; i++){
                    newfieldDD += '<option value="'+name[i]+'">'+name[i]+'</option>';

                  }
                  var newadd='</select><button type="button" id="TfieldDelete" class="btn btn-danger DD inline">Delete</button></div>';
                  var field=newf+newfieldDD+newadd;
                  $('#tab1').append(field);

                  break;   
                  case "#formRadioButton" :
                  var newfieldRB="";
                  var name=[];
                  var value=[];

                  $(".optionD").each(function() {
                   console.log($(this).val());
                   name.push($(this).val());
                 });

                  value="";
                  for(var i = 0 ; i < name.length ; i++){
                    newfieldRB = '<div class="" id="divRB"><div class="col-md-6"><label class="radio-inline"><input name="'+name[i]+'" value="'+name[i]+'" type="radio"><span>'+name[i]+'</span></label><button type="button" id="TfieldDelete" class="btn btn-danger RB inline">Delete</button></div>';
                    $('#tab1').append(newfieldRB);
                  }
                  break;
                  case "#formHeadline": 

                  var newfieldH="";
                  var headline="";
                  headline=$('#inputnameH').val();

                  newfieldH = '<div class="clearfix"></div><br/><div  id="divH"><div class="col-md-6"><h2>'+headline+'</h2></div><button type="button" id="TfieldDelete" class="btn btn-danger H inline">Delete</button></div><div class="clearfix"></div><br/>';
                  $('#tab1').append(newfieldH);
                  break;
                  case "#formParagraph": 

                  var newfieldP="";
                  paragraph=$('#inputnameP').val();
                  newfieldP = '<div class="clearfix"></div><br/><div  id="divP"><div class="col-md-6"><p style="word-break:break-all;">'+paragraph+'</p></div><button type="button" id="TfieldDelete" class="btn btn-danger P inline">Delete</button></div><div class="clearfix"></div><br/>';
                  $('#tab1').append(newfieldP);
                  break;

                  default:$('#tab1').append('<div class="clearfix"></div><br/><div  id="divL"><div class="col-md-6"><hr></div><button type="button" id="TfieldDelete" class="btn btn-danger L inline">Delete</button></div><div class="clearfix"></div><br/>');
                }


              }
              else
              {
                console.log('f'); 
                console.log(data.errors.label); 

                $.each(data.errors, function (i, item) {
                  console.log(item);
                  $('#error').append(item);
                });


           //  $('#error').append(data.errors.label);

         }
       },
       dataType: 'json'
     });

return false;

}



/*--add new tab--*/

$( "#addTab" ).click(function() {

 var newtab="";
 var newcontent="";

 newtab = '  <li><a href="#" role="tab" data-toggle="tab">newTab</a></li>';
 newcontent = '<div class="tab-pane" id="new">new contents</div>';

 $('#myTab').append(newtab);
 $('.tab-content').append(newcontent);

 flag=0;



});

$('#myTab a').click(function (e) {
 e.preventDefault()
 $(this).tab('show')
});

/*------------------------------------ text field---------------------------------------------------*/

/*--add text field--*/
$( "#addTfield" ).click(function() {



  $('#formtextField')[0].reset();

});
/*--saving and adding text field--*/
$( "#saveModalTF" ).click(function() {

  var id="#formtextField";
  postForm(id);

  return false;

});

/*--delete text field--*/
$('#tab1').on("click",'.tf' ,function(){

  $('#divtf').remove();
});



/*------------------------------------ text area---------------------------------------------------*/


/*--add text area--*/
$( "#addTarea" ).click(function() {

  $('#formtextArea')[0].reset();
});


/*--saving and adding text area--*/
$( "#saveModalTA" ).click(function() {

  var id="#formtextArea";
  postForm(id);


  return false;

});


/*--delete text area--*/
$('#tab1').on("click",'.ta' ,function(){


  $('#divta').remove();

});


/*------------------------------------ check box---------------------------------------------------*/


/*--add check box--*/

$( "#addCbox" ).click(function() {

  $('#formcheckBox')[0].reset();

});

/*--add option --*/


$( "#addOption" ).click(function() {
  var option="";

  option = ' <div class="col-md-4"><input type="text"  id="inputCname" name="option[]" class="form-control optionC" style="display:block" placeholder="option"></div><div class="col-md-4"><input type="text" id="inputCvalue" name="value[]" class="form-control" style="display:inline-block" placeholder="value"></div><div class="clearfix"></div><br/>';


  $('#Divoptions').append(option);



});

/*--add option DropDown --*/


$( "#addOptionD" ).click(function() {
  var option="";

  option = ' <div class="col-md-4"><input type="text"  id="inputCname" name="option[]" class="form-control optionD" style="display:block" placeholder="option"></div><div class="col-md-4"><input type="text" id="inputCvalue" name="value[]" class="form-control" style="display:inline-block" placeholder="value"></div><div class="clearfix"></div><br/>';
  $('#DivoptionsD').append(option);



});


/*--add option DropDown --*/

$( "#addOptionR" ).click(function() {
  var option="";

  option = ' <div class="col-md-4"><input type="text"  id="inputCname" name="option[]" class="form-control optionR" style="display:block" placeholder="option"></div><div class="col-md-4"><input type="text" id="inputCvalue" name="value[]" class="form-control" style="display:inline-block" placeholder="value"></div><div class="clearfix"></div><br/>';
  $('#DivoptionsR').append(option);



});



/*--saving and adding check box--*/
$( "#saveModalCB" ).click(function() {

 var id="#formcheckBox";
 postForm(id);

 return false;

});


/*--delete check box--*/
$('#tab1').on("click",'.cb' ,function(){


  $('#divcb').remove();

});


/*------------------------------------ drop down---------------------------------------------------*/


/*--add drop down--*/
$( "#addDD" ).click(function() {


  $('#formDropDown')[0].reset();

});

/*--saving and adding drop down--*/
$( "#saveModalDD" ).click(function() {

 var id="#formDropDown";
 postForm(id);
 return false;
});


/*--delete drop down--*/
$('#tab1').on("click",'.DD' ,function(){

  $('#divDD').remove();

});


/*------------------------------------ radio button---------------------------------------------------*/


/*--add radio button--*/
$( "#addRB" ).click(function() {

  $('#formRadioButton')[0].reset();

});



/*--saving and adding radio button--*/
$( "#saveModalRB" ).click(function() {

 var id="#formRadioButton";
 postForm(id);
 return false;

});

/*--delete radio button--*/
$('#tab1').on("click",'.RB' ,function(){


  $('#divRB').remove();

});



/*------------------------------------ Headline---------------------------------------------------*/


/*--add Headline--*/
$( '#addH' ).click(function() {

  console.log('testing');

  $('#formHeadline')[0].reset();

});



/*--saving and adding Headline--*/
$( '#saveModalH' ).click(function() {

 var id="#formHeadline";
 postForm(id);
 return false;

});

/*--delete Headline--*/
$('#tab1').on("click",'.H' ,function(){


  $('#divH').remove();

});

/*------------------------------------ Paragraph---------------------------------------------------*/


/*--add Paragraph--*/
$( "#addP" ).click(function() {

  $('#formParagraph')[0].reset();

});



/*--saving and adding Paragraph--*/
$( "#saveModalP" ).click(function() {

 var id="#formParagraph";
 postForm(id);
 return false;

});

/*--delete Paragraph--*/
$('#tab1').on("click",'.P' ,function(){


  $('#divP').remove();

});

/*------------------------------------ Line---------------------------------------------------*/


/*--add Line--*/
$( "#addL" ).click(function() {

 var id="#Line";
 postForm(id);




});
/*--delete Line--*/
$('#tab1').on("click",'.L' ,function(){


  $('#divL').remove();

});


/*------------------------------------ send form add links---------------------------------------------------*/

/*---fb----*/
$('.face').click(function() {
  $('.fb').show();  
});

/*---twitter----*/
$('.twit').click(function() {
  $('.tw').show();  
});

/*---linkedin----*/
$('.linked').click(function() {
  $('.ln').show();  
});

/*---google----*/
$('.goog').click(function() {
  $('.go').show();  
});

/*---github----*/
$('.git').click(function() {
  $('.ghub').show();  
});

/*---scholar----*/
$('.scholar').click(function() {
  $('.gs').show();  
});







});
     /*
    # =============================================================================
    #   Datepicker
    # =============================================================================
    */

    $('.datepicker').datepicker();
    nowTemp = new Date();
    now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    checkin = $("#dpd1").datepicker({
      onRender: function(date) {
        if (date.valueOf() < now.valueOf()) {
          return "disabled";
        } else {
          return "";
        }
      }
    }).on("changeDate", function(ev) {
      var newDate;
      if (ev.date.valueOf() > checkout.date.valueOf()) {
        newDate = new Date(ev.date);
        newDate.setDate(newDate.getDate() + 1);
        checkout.setValue(newDate);
      }
      checkin.hide();
      return $("#dpd2")[0].focus();
    }).data("datepicker");
    checkout = $("#dpd2").datepicker({
      onRender: function(date) {
        if (date.valueOf() <= checkin.date.valueOf()) {
          return "disabled";
        } else {
          return "";
        }
      }
    }).on("changeDate", function(ev) {
      return checkout.hide();
    }).data("datepicker"); 

   
   // add writer button
var w=0;
var wno=1;
   $('#addwriter').click(function(){
      w++;
      wno++;
     $('#hdnWriterCount').val(w);
     $('.new-writer-div').append('<hr><br><div align="center"><strong>'+wno+'</strong></div><br><div class="form-group"><label class="control-label col-md-2">Writer email</label><div class="col-md-7"><input type="text" placeholder="e-mail" name="writer_email_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">First Name</label><div class="col-md-7"><input type="text" placeholder="First Name" name="first_name_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">Last Name</label><div class="col-md-7"><input type="text" placeholder="Last Name" name="last_name_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">Organisation</label><div class="col-md-7"><input type="text" placeholder="Organisation" name="organisation_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">Position</label><div class="col-md-7"><input type="text" placeholder="Position" name="position_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">address1</label><div class="col-md-7"><input type="text" placeholder="address1" name="address1_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">address2</label><div class="col-md-7"><input type="text" placeholder="address2" name="address2_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">city</label><div class="col-md-7"><input type="text" placeholder="address3" name="address3_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">zip</label><div class="col-md-7"><input type="text" placeholder="zip" name="zip_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">country</label><div class="col-md-7"><input type="text" placeholder="country" name="country_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">state</label><div class="col-md-7"><input type="text" placeholder="state" name="state_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">phone</label><div class="col-md-7"><input type="text" placeholder="phone" name="phone_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">mobile</label><div class="col-md-7"><input type="text" placeholder="mobile" name="mobile_'+w+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">fax</label><div class="col-md-7"><input type="text" placeholder="fax" name="fax_'+w+'" class="form-control"></div></div><br><div></div><div class="col-md-9 text-center"><a href="" id="addskill" data-id="'+wno+'" class="btn btn-primary addskill">add skill</a></div><div class="clearfix"></div>');
     console.log($('#hdnWriterCount').val());
     return false;
   });

  // add recepient button
var r=0;
var rno=1;
$('#addrecepient').click(function(){
 r++;
 rno++;

 $('#hdnRecptCount').val(r);
 $('.new-recpt-div').append('<hr><br><div align="center"><strong>'+rno+'</strong></div><br><div class="form-group"><label class="control-label col-md-2">First Name</label><div class="col-md-7"><input type="text" placeholder="First Name" name="first_name_r_'+r+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">Last Name</label><div class="col-md-7"><input type="text" placeholder="Last Name" name="last_name_r_'+r+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">Organisation</label><div class="col-md-7"><input type="text" placeholder="Organisation" name="organisation_r_'+r+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">Position</label><div class="col-md-7"><input type="text" placeholder="Position" name="position_r_'+r+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">address1</label><div class="col-md-7"><input type="text" placeholder="address1" name="address1_r_'+r+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">address2</label><div class="col-md-7"><input type="text" placeholder="address2" name="address2_r_'+r+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">zip</label><div class="col-md-7"><input type="text" placeholder="zip" name="zip_r_'+r+'" class="form-control"></div></div><div class="form-group"><label class="control-label col-md-2">Recipient e-mail</label><div class="col-md-7"><input type="text" placeholder="e-mail" name="recipient_email_'+r+'" class="form-control" value=""></div></div>');
 console.log($('#hdnRecptCount').val());
 return false;

});

var count = 1;
$(document).on('click','.addskill',function(){
var id = $(this).data('id');
console.log(id);
$(this).parent().prev('div').append('<div class="form-group"><label class="control-label col-md-2">skill</label><div class="col-md-7"><input type="text" placeholder="skill" name="skill_'+id+'_'+count+'" class="form-control"></div></div>');
count++;
 return false;
});


