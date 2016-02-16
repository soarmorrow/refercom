<!-- /*
*    input contols that are loaded to form-builder via AJAX
*
*/ -->


<div class="form-group">
  <!-- Text input -->
  <label class="col-sm-4 control-label" for="textInput">Text Input</label>
  <div class="col-sm-7">
    <input id="textInput" name="textInput" type="text" placeholder="placeholder" class="form-control">
    <br>
  </div>
</div>

<div class="form-group">
  <!-- Textarea -->
  <label class="col-sm-4 control-label" for="textarea">Text Area</label>
  <div class="col-sm-7">
    <div class="input-group">
      <textarea id="textarea" name="textarea" class="form-control">Default text</textarea>
    </div>
    <br>
  </div>
</div>

<div class="form-group">
  <legend>Skills:</legend>
  <div class="form-group">  
    <!-- Rating -->
    <!--skill-->
    <label class="col-sm-4 control-label" for="rating">Skill Name</label>
    <div class="col-sm-7">
     <input id="input-rating" name="rating" value="4" type="text" class="rating form-control rating-skill" placeholder="placeholder" min=0 max=5 step=0.2 data-size="xs"> 
     <br>
   </div>
 </div>

 <div class="form-group">
  <!-- percentage -->
  <label class="col-sm-4 control-label" for="amount">years of experience</label>
  <div class="col-sm-7">
    <p><input type="text" id="amount" name="percentage" class="perc-skill" readonly style="border:0; color:#f6931f; font-weight:bold;"></p>
    <div id="slider-range-min"></div>
  </div>
</div>
</div>

<br>

<!-- /*
*    Script to run rating and slider jquery controls
*
*/ -->


<script>
  $(function () {
   $("#input-rating").rating();

   $( "#slider-range-min" ).slider({
    range: "min",
    value: 5,
    min: 1,
    max: 50,
    slide: function( event, ui ) {
      $( "#amount" ).val( "" + ui.value );
    }
  });
   $( "#amount" ).val( "" + $( "#slider-range-min" ).slider( "value" ) );
 });
</script>