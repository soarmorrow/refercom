@extends('frontend/layouts/default')

<?php $statusLabels = array('active' => 'success' ,'resent' => 'warning' , '' => 'warning' ); ?>



{{-- Page content --}}
@section('content')

  <div class="page-title">
    <h1>
    {{ $folder->folder_name }}
    </h1>
  </div>
  <div class="row">
    <!-- Basic Table -->
    <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix">
              <div class="widget-content padded clearfix">
                @if (!$requests->isEmpty())
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <th>
                          Form
                        </th>
                        <th>
                          Email
                        </th>
                        <th>
                          Sent At
                        </th>
                        <th>
                          Submitted
                        </th>
                        <th>
                          Actions
                        </th>
                       
                      </thead>
                      <tbody>
                      
                        @foreach ( $requests as $r)
                        <tr>
                          <td>
                            {{ $r->form()->first()->name }}
                          </td>
                          <td>
                            {{ $r->writer_email}}
                          </td>
                          <td>
                            {{ date("d/m/Y" , strtotime($r->created_at)) }}
                          </td>
                          <td>
                            {{ date("d/m/Y" , strtotime($r->updated_at)) }}
                          </td>
                          <td>
                            <a href="{{ route( 'pdf/submission', $r->id ) }}" class="btn btn-primary">Download</a>
                          </td>
                         
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @else
                  No forms found.
                @endif
                
              </div>

            </div>

          </div>
          <!-- end Responsive Table -->
  </div>






  <div id="shareModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Share</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal" onsubmit="return false;" action="" method="post" id="formShareSubmit">
          <div class="form-group">
          <label class="control-label col-md-2">email</label>
          <div class="col-md-7">
            <input  placeholder="enter e-mail to share.." email name="shareEmail"  type="email"  class="form-control"  />
          </div>
          <div class="clearfix"></div>
         <hr>
          
          <hr>

           <!--success msg-->
                <div class="alert alert-success alert-dismissible successMsgSh" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>success!</strong> saved
                </div>
                <!--error msg-->
                <div class="alert alert-danger alert-dismissible errorMsgSh" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  <strong>Error!</strong> Failed!
                </div>
        
      </div>
      <div class="modal-footer">
        <?php
          $host = URL::to("/");
          $slug = "fkgjhflkghjlfkgh";
          $url = $host.'/forms/'.$slug;
        ?>
        <a href="#" target="_blank" class="btn btn-primary social-fb-share"><i class="fa fa-facebook"></i></a>
        <a href="#" target="_blank" class="btn btn-primary social-ln-share"><i class="fa fa-linkedin"></i></a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btnShareSubmit">Share</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  var baseUrl = '{{ URL::to("/") }}';
  window.id=0;
  $('.btnShare').click(function() {
    window.id = $(this).data('id');
     // $('.sharelink').html($(this).data('link'));
      var fbshare = "http://www.facebook.com/sharer/sharer.php?u=";
      var lnshare = "https://www.linkedin.com/shareArticle?mini=true&url=";
      $('.social-fb-share').attr({
        'href': fbshare+$(this).data('link')
      });
      $('.social-ln-share').attr({
        'href': lnshare+$(this).data('link')
      });
  });
    
    
$('#addmodal').click(function() {

window.resquestid=$(this).data('id');

});
     

   $('#btnAddtoFolder').click(function() {

      
console.log('test');
       var data = $("#formfolder").serialize();
      
       console.log(resquestid);
    
       $.ajax({
            url: baseUrl+'/ajax/addtofolder',
            method:'post',
            data: data+'&request_id='+window.resquestid,
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
 
   $('.btnShareSubmit').click(function() {

      

       var data = $("#formShareSubmit").serialize();
       var pdf=$(".sharelink").html();
      // console.log(pdf);
       data = data+'&pdf='+pdf;
       $.ajax({
            url: baseUrl+'/ajax/share',
            method:'post',
            data: data+'&request_id='+window.id,
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

   
</script>

@stop