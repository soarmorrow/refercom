
  $(document).ready(function() {
    /*
    # =============================================================================
    #   Navbar scroll animation
    # =============================================================================
    */

    $(".page-header-fixed .navbar.scroll-hide").mouseover(function() {
      $(".page-header-fixed .navbar.scroll-hide").removeClass("closed");
      return setTimeout((function() {
        return $(".page-header-fixed .navbar.scroll-hide").css({
          overflow: "visible"
        });
      }), 150);
    });
    $(function() {
      var delta, lastScrollTop;
      lastScrollTop = 0;
      delta = 50;
      return $(window).scroll(function(event) {
        var st;
        st = $(this).scrollTop();
        if (Math.abs(lastScrollTop - st) <= delta) {
          return;
        }
        if (st > lastScrollTop) {
          $('.page-header-fixed .navbar.scroll-hide').addClass("closed");
        } else {
          $('.page-header-fixed .navbar.scroll-hide').removeClass("closed");
        }
        return lastScrollTop = st;
      });
  
    });
    /*
    # =============================================================================
    #   Mobile Nav
    # =============================================================================
    */

    $('.navbar-toggle').click(function() {
      return $('body, html').toggleClass("nav-open");
    });
    /*
    # =============================================================================
    #   Style Selector
    # =============================================================================
    */

    $(".style-selector select").each(function() {
      return $(this).find("option:first").attr("selected", "selected");
    });
    $(".style-toggle").bind("click", function() {
      if ($(this).hasClass("open")) {
        $(this).removeClass("open").addClass("closed");
        return $(".style-selector").animate({
          "right": "-240px"
        }, 250);
      } else {
        $(this).removeClass("closed").addClass("open");
        return $(".style-selector").show().animate({
          "right": 0
        }, 250);
      }
    });
    $(".style-selector select[name='layout']").change(function() {
      if ($(".style-selector select[name='layout'] option:selected").val() === "boxed") {
        $("body").addClass("layout-boxed");
        return $(window).resize();
      } else {
        $("body").removeClass("layout-boxed");
        return $(window).resize();
      }
    });
    $(".style-selector select[name='nav']").change(function() {
      if ($(".style-selector select[name='nav'] option:selected").val() === "top") {
        $("body").removeClass("sidebar-nav");
        return $(window).resize();
      } else {
        $("body").addClass("sidebar-nav");
        return $(window).resize();
      }
    });
    $(".color-options a").bind("click", function() {
      $(".color-options a").removeClass("active");
      return $(this).addClass("active");
    });
    $(".pattern-options a").bind("click", function() {
      var classes;
      classes = $("body").attr("class").split(" ").filter(function(item) {
        if (item.indexOf("bg-") === -1) {
          return item;
        } else {
          return "";
        }
      });
      $("body").attr("class", classes.join(" "));
      $(".pattern-options a").removeClass("active");
      $(this).addClass("active");
      return $("body").addClass($(this).attr("id"));
    });
    /*
    # =============================================================================
    #   Bootstrap Tabs
    # =============================================================================
    */

   // $("#myTab a:last").tab("show");
    /*
    # =============================================================================
    #   Bootstrap Popover
    # =============================================================================
    */

  //  $(".popover-trigger").popover();
    /*
    # =============================================================================
    #   Bootstrap Tooltip
    # =============================================================================
    */

   // $(".tooltip-trigger").tooltip();
    

    /*
    # =============================================================================
    #   Popover JS
    # =============================================================================
    */

  //  $('#popover').popover();
  });