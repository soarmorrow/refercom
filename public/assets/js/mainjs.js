
    /*
    # =============================================================================
    #   Login/signup animation
    # =============================================================================
    */

    $(window).load(function() {
      return $(".login-container").addClass("active");
    });

    //  $.get('http://localhost/test456/public/ajax', function(){

    // });
    /*
    # =============================================================================
    #   Form Input Masks
    # =============================================================================
    */

    /*$(":input").inputmask();
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
  /*
    # =============================================================================
    #   Input placeholder fix
    # =============================================================================
    */

    if (!Modernizr.input.placeholder) {
      $("[placeholder]").focus(function() {
        var input;
        input = $(this);
        if (input.val() === input.attr("placeholder")) {
          input.val("");
          return input.removeClass("placeholder");
        }
      }).blur(function() {
        var input;
        input = $(this);
        if (input.val() === "" || input.val() === input.attr("placeholder")) {
          input.addClass("placeholder");
          return input.val(input.attr("placeholder"));
        }
      }).blur();
      $("[placeholder]").parents("form").submit(function() {
        return $(this).find("[placeholder]").each(function() {
          var input;
          input = $(this);
          if (input.val() === input.attr("placeholder")) {
            return input.val("");
          }
        });
      });
    }

   