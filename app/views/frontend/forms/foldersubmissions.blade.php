@extends('frontend/layouts/default')

<?php $statusLabels = array('active' => 'success' ,'resent' => 'warning' , '' => 'warning' ); ?>



{{-- Page content --}}
@section('content')

  <div class="page-title">
    <h1>
    Folders
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
                          Folder
                        </th>
                        <th>
                          Created At
                        </th>
                        <th>
                          Modified At
                        </th>
                      </thead>
                      <tbody>
                        @foreach ( $requests as $r)
                        <tr>
                          <td>
                           <a href="{{ route( 'folder_submissions', $r->id ) }}" >{{ $r->folder_name }}</a>
                          </td>
                          <td>
                            {{ date("m/d/Y" , strtotime($r->created_at)) }}
                          </td>
                          <td>
                            {{ date("m/d/Y" , strtotime($r->updated_at)) }}
                          </td>
                           <td>
                            <a href="{{ route( 'folder_submissions', $r->id ) }}"><button  class="btn btn-info">View</button></a> 
                            <a href="" id="btnEditFolder" data-toggle="modal" data-target="#folderReModal" data-id="{{$r->id}}"><button class="btn btn-default">Edit Folder Name</button></a>
                            <a href="" data-id="{{$r->id}}" class="btn btn-success btnShareFolder" data-toggle="modal" data-target="#shareModalF" data-link="{{route('public_folder_submissions',$r->id)}}" >Share</a>
                            <a href="{{ route( 'folder-ranking', $r->id ) }}"><button  class="btn btn-primary">Folder Ranking</button></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @else
                  No folders found.
                @endif
                 <a class="btn btn-lg btn-success pull-left" data-toggle="modal" data-target="#myModal" href="#">Create New Folder</a>
              </div>

            </div>

          </div>
          <!-- end Responsive Table -->
  </div>


 <div id="shareModalF" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Share</h4>
      </div>
      <div class="modal-body">
         <form class="form-horizontal" onsubmit="return false;" action="" method="post" id="formShareSubmitF">
          <div class="form-group">
          <label class="control-label col-md-2">email</label>
          <div class="col-md-7">
            <input  placeholder="enter e-mail to share.." email name="shareEmail"  type="email"  class="form-control"  />
          </div>
          <div class="clearfix"></div>
         <hr>
           <p class="sharelink"></p>
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
        <button type="button" class="btn btn-primary btnShareSubmitF">Share</button>
      </div>
    </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>








  <div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Create Folder</h4>
      </div>
      <div class="modal-body">
          <input type="text" class="form-control" id="folder_name" placeholder="Enter folder name">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="saveFolder" class="btn btn-primary">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- edit letter name modal -->
<div id="folderReModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="alert alert-success alert-dismissible successMsgSh" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>success!</strong> saved
      </div>
      <!--error msg-->
      <div class="alert alert-danger alert-dismissible errorMsgSh" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Error!</strong> Failed!
      </div>
      <form id="formEditFolder">
        <div class="modal-body">
          <label>New Name</label><input type="text" name="rname" class="form-control">
          <input type="text" style="display:none" id="hdnfolderid" />
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnRenameF" class="btn btn-primary">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 
<script type="text/javascript">
  var baseUrl = '{{ URL::to("/") }}';
  window.id=0;
  $('.btnShareFolder').click(function() {
    window.id = $(this).data('id');
      $('.sharelink').html($(this).data('link'));
      var fbshare = "http://www.facebook.com/sharer/sharer.php?u=";
      var lnshare = "https://www.linkedin.com/shareArticle?mini=true&url=";
      $('.social-fb-share').attr({
        'href': fbshare+$(this).data('link')
      });
      $('.social-ln-share').attr({
        'href': lnshare+$(this).data('link')
      });
  });
    
   
   $('#saveFolder').click(function(){

    var folder_name = $("#folder_name").val();
    var data='folder_name='+folder_name;
    console.log(data);
    
     $.ajax({
            url: baseUrl+'/ajax/saveFolder',
            method:'post',
            data: data,
            success: function(data){
                if(data.status=="success")
                {
                   
                    $('#myModal').modal('hide');
                    $('.successMsgSh').html('folder successfully created').show();
                    // $('.btn-share').show();
                    // $('.btn-submit').hide();
                    $('.errorMsgSh').hide();
                     location.reload(); 
                }
                else
                {
                 
                    $('.errorMsgSh').html('An error occured! folder creation failed').show();
                    $('.successMsgSh').hide();
                }
            },
            dataType: 'json'
        });
     return false;


   }); 

     

    
   $('.btnShareSubmitF').click(function() {

      

       var data = $("#formShareSubmit").serialize();
       var pdf=$(".sharelink").html();
      // console.log(pdf);
       data = data+'&pdf='+pdf;
       $.ajax({
            url: baseUrl+'/ajax/shareFolder',
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

   $(function(){
    $('#btnEditFolder').click(function(){
    // alert($(this).data('id'));
    $('#hdnfolderid').val($(this).data('id'));
  });
  
    $('#btnRenameF').click(function(){

      var data = $("#formEditFolder").serialize();
      var hdnfolderid = $('#hdnfolderid').val(); 
      data = data;
      $.ajax({
        url: baseUrl+'/ajax/edit-folder-name',
        method:'post',
        data: data+'&folder_id='+hdnfolderid,
        success: function(data){
          if(data.status=="success")
          {

           $('.successMsgSh').html('form successfully renamed').show();

           $('.errorMsgSh').hide();
           location.reload(true);

         }
         else
         {

          $('.errorMsgSh').html('An error occured! form re-naming failed').show();
          $('.successMsgSh').hide();
        }
      },
      dataType: 'json'
    });

    });

  });
</script>

@stop