$(function() {
	/*
    # =============================================================================
    #   Form wizard
    # =============================================================================
    */

    var isSaved = false;
   


    $("#wizard").bootstrapWizard({
    	nextSelector: ".btn-next",
    	previousSelector: ".btn-previous",
    	onNext: function(tab, navigation, index) {
    		var $current, $percent, $total;
    		if (index === 1) {

    			var flag = false;
    			if (!$("#name").val()) {
    				$("#name").focus();
    				$("#name").addClass("has-error");
    				
    				return false;

    			}


    			if(!isSaved){
    				alert('please..save and continue');
    				return false;
    			}
    						$total = navigation.find("li").length;
    						$current = index + 1;
    						$percent = ($current / $total) * 100;
    						return $("#wizard").find(".progress-bar").css("width", $percent + "%");

    			

    		}

    		
    	},
    	onPrevious: function(tab, navigation, index) {
    		var $current, $percent, $total;
    		$total = navigation.find("li").length;
    		$current = index + 1;
    		$percent = ($current / $total) * 100;
    		return $("#wizard").find(".progress-bar").css("width", $percent + "%");
    	},
    	onTabShow: function(tab, navigation, index) {
    		var $current, $percent, $total;
    		$total = navigation.find("li").length;
    		$current = index + 1;
    		$percent = ($current / $total) * 100;
    		return $("#wizard").find(".progress-bar").css("width", $percent + "%");
    	}
    });

    /*
    # =============================================================================
    #   Form Input Masks
    # =============================================================================
    */

    $(":input").inputmask();
    /*
    # =============================================================================
    #   Validation
    # =============================================================================
    */

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

$('.btn-save').click(function() {


	$('.errorMsg').hide();
	$('.successMsg').hide();

	$.ajax({
		url: 'ajax',
		method:'post',
		data: { test : 456 },
		success: function(data){
			if(data.status=="success")
			{


				isSaved = true;

               $('.successMsg').show();

               $('#continueSubmit').prop('disabled', false);

			}
			else
			{
				isSaved = false;
				$('.errorMsg').show();

			}
		},
		dataType: 'json'
	});

	

});



});


