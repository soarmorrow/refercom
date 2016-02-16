<div class="form-group">

  <!-- Rating -->
  <label class="col-sm-4 control-label" for="rating">Rating</label>
  <div class="col-sm-7">
    
     <input id="input-rating1" name="rating" value="4" type="text" class="rating form-control" placeholder="placeholder" min=0 max=5 step=0.2 data-size="xs">
 
   <br>
 </div>
</div>

<div class="form-group">
<!-- percentage -->
<label class="col-sm-4 control-label" for="amount">%label</label>
<div class="col-sm-7">
  <p><input type="text" id="amount" name="percentage" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
<div id="slider-range-min1"></div>
</div>
</div>

<script>
    $(function () {
       $("#input-rating1").rating();

       $( "#slider-range-min1" ).slider({
        range: "min",
        value: 37,
        min: 1,
        max: 100,
        slide: function( event, ui ) {
          $( "#amount" ).val( "" + ui.value );
        }
      });
       $( "#amount" ).val( "" + $( "#slider-range-min" ).slider( "value" ) );
    });
</script>