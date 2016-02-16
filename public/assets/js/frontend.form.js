

$(function() {

  $('.datepicker').datepicker({
  })

  var $currentTab = 0;
  var $isSaved = [];
  





  $("#wizard").bootstrapWizard({
   nextSelector: ".btn-next",
    	//previousSelector: ".btn-previous",
    
    	onNext: function(tab, navigation, index) {
    		var $current, $percent, $total;
        $('.successMsg').hide();
        $('.successMsg').hide();
  
  //skipping second tab saving,just continue to next tab 
            
        if($currentTab == 0)
        {

           $('.btn-save').hide();

        }
        else if($currentTab == 1) 
        {
         //  $('.btn-save').show();

        }
        else if(!window.saved){
          $('.errorMsg').html('Please save before continue..');
          $('.errorMsg').show();
          $('html, body').animate({scrollTop : 0},800);
          return false;
        }
        else{

       //   $('.btn-save').show();
        }


          
        $('html, body').animate({scrollTop : 0},800);
        $currentTab = index;
        $total = navigation.find("li").length;
        $current = index + 1;
        $percent = ($current / $total) * 100;

        if((index+1)==$total)
        {
          $sigdiv = $("#signature").jSignature({'UndoButton':true , 'width' : 300 , 'height' : 200});
          $('.btn-next,.btn-save').hide();

        }
        return $("#wizard").find(".progress-bar").css("width", $percent + "%");
      },
        // onPrevious: function(tab, navigation, index) {
        //     var $current, $percent, $total;
        //     currentTab = index;
        //     $('html, body').animate({scrollTop : 0},800);
        //     $total = navigation.find("li").length;
        //     $current = index + 1;
        //     $percent = ($current / $total) * 100;
        //     return $("#wizard").find(".progress-bar").css("width", $percent + "%");
        // },
        onTabShow: function(tab, navigation, index) {

          var $current, $percent, $total;
          $total = navigation.find("li").length;
          $current = index + 1;
          $percent = ($current / $total) * 100;

          return $("#wizard").find(".progress-bar").css("width", $percent + "%");
        }
      });

$(":input").inputmask();

$("#validate-form").validate({
 rules: {
  firstname: "required",
  lastname: "required",
  username: {
   required: true,
   minlength: 2
 },
 password: {
   required: true,
   minlength: 5
 },
 confirm_password: {
   required: true,
   minlength: 5,
   equalTo: "#password"
 },
 email: {
   required: true,
   email: true
 }
},
messages: {
  firstname: "Please enter your first name",
  lastname: "Please enter your last name",
  username: {
   required: "Please enter a username",
   minlength: "Your username must consist of at least 2 characters"
 },
 password: {
   required: "Please provide a password",
   minlength: "Your password must be at least 5 characters long"
 },
 confirm_password: {
   required: "Please provide a password",
   minlength: "Your password must be at least 5 characters long",
   equalTo: "Please enter the same password"
 },
 email: "Please enter a valid email address"
}
});


$('.btnShareSubmit').click(function() {



 var data = $("#formShareSubmit").serialize();

 var pdf=$(".sharelink").html();
      // console.log(pdf);
      data = data+'&pdf='+pdf;
      $.ajax({
        url: baseUrl+'/ajax/share',
        method:'post',
        data: data+'&request_id='+requestId+'&form_id='+formId,
        success: function(data){
          if(data.status=="success")
          {

            $('.successMsgSh').html('form successfully shared').show();
                    // $('.btn-share').show();
                    // $('.btn-submit').hide();
                    $('.errorMsgSh').hide();

                  }
                  else
                  {

                    $('.errorMsgSh').html('An error occured! form sharing failed').show();
                    $('.successMsgSh').hide();
                  }
                },
                dataType: 'json'
              });
      return false;
    });


$('#btnPreview').click(function() {



 
var data = $("#formSubmit").serialize();

 $.ajax({
  url: baseUrl+'/ajax/getpreview',
  method:'post',
  data: data+'&request_id='+requestId+'&form_id='+formId,
  success: function(data){
    if(data.status=="success")
    {

     $('#preview').toggle();

                 //  $('.thedate').html(data.request['updated_at']);
                   // $('#last_name').html(data.seeker['last_name']);
                   // $('#address1').html(data.seeker['address1']);
                   // $('#address2').html(data.seeker['address2']);
                   // $('#address3').html(data.seeker['address3']);
                 
                 $('#temp_chosen_desc').val(data.request.description);

                 $('#temp_chosen_skill').val(data.request.candidate_skills);

                 //--------------------
                 $('#first_name').html(data.seeker['first_name']);
                 $('#last_name').html(data.seeker['last_name']);
                 $('#address1').html(data.seeker['address1']);
                 $('#address2').html(data.seeker['address2']);
                 $('#address3').html(data.seeker['address3']);

                 $('#phone').html(data.seeker['phone']);
                 $('#mobile').html(data.seeker['mobile']);

                 $('#fax').html(data.seeker['fax']);
                 $('#zip').html(data.seeker['zip']);
                 $('#state').html(data.seeker['state']);
                 $('#country').html(data.seeker['country']);

                 $('#sorganisation').html(data.seeker['organisation']);
                 $('#sposition').html(data.seeker['position']);
                 $('#sfacebook').html(data.seeker['facebook']);
                 $('#stwitter').html(data.seeker['twitter']);
                 $('#slinkedin').html(data.seeker['linkedin']);
                 $('#sgoogle').html(data.seeker['google']);
                 $('#sgooglescholar').html(data.seeker['google_scholar']);
                 $('#sgithub').html(data.seeker['github']);
                 $('#knownfrom').html(data.seeker['know_from']);
                 $('#knownto').html(data.seeker['know_to']);
                 $('#rank').html(data.seeker['rank']);



                 $('#wfirst_name').html(data.writer['first_name']);
                 $('#wlast_name').html(data.writer['last_name']);
                 $('#waddress1').html(data.writer['address1']);
                 $('#waddress2').html(data.writer['address2']);
                 $('#waddress3').html(data.writer['address3']);

                 $('#wphone').html(data.writer['phone']);
                 $('#wmobile').html(data.writer['mobile']);

                 $('#wfax').html(data.writer['fax']);
                 $('#wzip').html(data.writer['zip']);
                 $('#wstate').html(data.writer['state']);
                 $('#wcountry').html(data.writer['country']);

                 $('#worganisation').html(data.writer['organisation']);
                 $('#wposition').html(data.writer['position']);
                 $('#wfacebook').html(data.writer['facebook']);
                 $('#wtwitter').html(data.writer['twitter']);
                 $('#wlinkedin').html(data.writer['linkedin']);
                 $('#wgoogle').html(data.writer['google']);
                 $('#wgooglescholar').html(data.writer['google_scholar']);
                 $('#wgithub').html(data.writer['github']);






               }
               else
               {

               }
             },
             dataType: 'json'
           });
return false;
});

$('.btn-submit').click(function() {

  var sign = $sigdiv.jSignature('getData', 'default');

  var data = $("#formSubmit").serialize();

  var pdf=$(".sharelink").html();
      // console.log(pdf);
      data = data+'&pdf='+pdf+'&sign='+sign;

      $.ajax({
        url: baseUrl+'/ajax/submit',
        method:'post',
        data: data+'&request_id='+requestId+'&form_id='+formId,
        success: function(data){
          if(data.status=="success")
          {

            $('.successMsg').html('form successfully submited').show();
            $('.btn-share').show();

            $('.btn-submit').hide();


          }
          else
          {

            $('.errorMsg').html('An error occured! form submition failed').show();
          }
        },
        dataType: 'json'
      });
      return false;
    });

$('.btn-next').click(function() {

 $('.errorMsg').hide();
 $('.successMsg').hide();
 $('html, body').animate({scrollTop : 0},800);

 var url, data;

 if($currentTab === 1){
  url = 'ajax/seeker';
  data = $("#formSeeker").serialize();
}
else if($currentTab === 2){
  url =  'ajax/writer';
  data = $("#formWriter").serialize();
}
else{
  url = 'ajax/fields';
  data = $("#tab_2").serialize();

}

$.ajax({
  url: baseUrl+'/'+url,
  method:'post',
  data: data+'&request_id='+requestId+'&form_id='+formId,
  success: function(data){
   if(data.status=="success")
   {
    $isSaved[$currentTab] = true;
    window.saved = true;
    $('.successMsg').html('Data successfully saved').show();

  }
  else
  {

      window.saved = false;

    $isSaved[$currentTab] = false;
    $('#wizard').bootstrapWizard('previous');
    $('.errorMsg').html('An error occured! form submition failed').show();
  }
},
dataType: 'json'
});
});
});


