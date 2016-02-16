@extends('frontend/layouts/default')

<?php $statusLabels = array('active' => 'success' ,'resent' => 'warning' , '' => 'warning','complete' => 'primary' ); ?>


@section('css')
<link href="{{URL::asset('assets/css/alertify.min.css')}}" rel="stylesheet">
<style type="text/css">
  .hover-drop{

   background: #e5e5ea; 
  }
  .drop-alert-box{

    position: fixed;
    top: 50%;
    left: 45%;
    z-index: 10000;
    display: none;
  }
  .drop-alert-box-not{
   position: fixed;
    top: 50%;
    left: 45%;
    z-index: 10000;
    display: none;

  }
  .alert-drop-not{
    background: #b31c22;
    color: white;
    border: none;
    box-shadow: 0 0 5px #000;
    -webkit-box-shadow: 0 0 5px #000;
    -moz-box-shadow: 0 0 5px #000;

  }
  .alert-drop{
    background: #007aff;
    color: white;
    border: none;
    box-shadow: 0 0 5px #000;
    -webkit-box-shadow: 0 0 5px #000;
    -moz-box-shadow: 0 0 5px #000;

  }
  .close{
    color: white;
  }
  .ondragDiv{
   box-shadow: 0 0 5px #000;
   -webkit-box-shadow: 0 0 5px #000;
   -moz-box-shadow: 0 0 5px #000;
   padding: 5px;
   background:#ccc;
  }
</style>
@stop


{{-- Page content --}}
@section('content')

@if($organization)
<p align="center"> You have no permission to view this page </p>
@else

<div class="drop-alert-box">
  <div class="alert alert-success alert-drop" role="alert">
    
    <strong>Dropped!</strong> Letter dropped to the folder
  </div>
</div>

<div class="drop-alert-box-not">
  <div class="alert alert-success alert-drop-not" role="alert">
    
    <strong>Denied!</strong> you can drop only recommendations and Letters
  </div>
</div>

<div class="page-title">
  <h1>
    Letter requests
    <a class="btn btn-lg btn-success pull-right" href="{{ URL::route('new/form') }}">New Request</a>
  </h1>

</div>
<div class="clearfix"></div>
<div class="row">

  <!-- Notifications -->
      @include('frontend/notifications')
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
                Writer
              </th>
              <th>
                Email
              </th>
              <th>
                Send At
              </th>
              <th>
                Deadline
              </th>
              <th>
                Status
              </th>
              <th>
                Actions
              </th>
            </thead>
            <tbody>
              @foreach ( $requests as $r)
              @if(($r->status) != 'complete')
              <tr>
                <td>
                  {{ $r->form()->first()->name }}
                </td>
                <td>
                  {{ $r['writer']['first_name']}} &nbsp; {{ $r['writer']['last_name']}}
                </td>
                <td>
                  {{ $r->writer_email}}
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($r->created_at))}}
                </td>
                <td>
                  {{date("m/d/Y" , strtotime($r->deadline)) }}
                </td>
                <td>
                  <span class="label label-{{ $statusLabels[ $r->status ] }}">{{ $r->status }}</span>
                </td>
                <td>
                <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action<span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="{{ route('resend', $r->id) }}"><i class="fa fa-plus"></i>Resend</a>
                        </li>
                        <li>
                          <a href="{{ route( 'requestdelete', $r->id ) }}" class="btnSubDelete"><i class="fa fa-trash-o"></i>Delete</a>
                        </li> 
                      </ul>
                    </div>

                </td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        No Letter requests found.
        @endif
      </div>
    </div>
  </div>
  <!-- end Responsive Table -->
</div>

<br/>
<div class="page-title">
  <h1>
    Letter Submissions  @if(!$organization) | <a style="color:#5E5E5E" href="{{route('timeline')}}">See Timeline view</a> @endif @if(!$organization) @if (!$submissions->isEmpty()) @endif @endif
  </h1>
</div>
<div class="row">
  <!-- Basic Table -->
  <div class="col-lg-12">
    <div class="widget-container fluid-height clearfix">
      <div class="widget-content padded clearfix">
        <div class="table-responsive">
          <table class="table tblSubmisssion">
            <thead>
              <th>
                Form
              </th>
              <th>
                Writer
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
              @foreach ( $recommendations as $r)
              <tr id="{{$r->id}}" type="recommendation" formname="Linkedin Recommendation" >
                <td>
                  Linkedin Recommendation
                </td>
                 <td>
                 'N/A'&nbsp;
                </td>
                <td>
                  {{ $r->recommended_by }}
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($r->created_at)) }}
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($r->updated_at)) }}
                </td>
                <td>
                 
                    <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action<span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="{{ route( 'pdf/recommendation', $r->id ) }}"><i class="fa fa-plus"></i>Download</a>
                        </li>
                        <li>
                          <a href="{{ route( 'recommenddelete', $r->id ) }}" class="btnSubDelete"><i class="fa fa-trash-o"></i>Delete</a>
                        </li> 
                        <li>
                          <a data-id="{{$r->id}}" data-type="recommendation"  data-toggle="modal" data-target="#folderModal" class="addmodals"><i class="fa fa-folder-open-o"></i>Add to folder</a>
                        </li>
                        <li>
                          <a href="#" data-id="{{$r->id}}" class="btnShare" data-toggle="modal" data-target="#shareModal2" data-link="{{ route( 'pdf/recommendation', $r->id ) }}"><i class="fa fa-share "></i>Share</a>       
                        </li>

                      </ul>
                    </div>
                     

                  
                  
                    
                </td>

              </tr>
              @endforeach
              @foreach ( $ocr as $oc)
              <tr>
                <td>
                  {{ $oc->form_name }}
                </td>
                <td>
                  'N/A'
                </td>
                <td>
                 'N/A'&nbsp;
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($oc->created_at)) }}
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($oc->updated_at)) }}
                </td>
                <td>
                   <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action<span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="{{ route( 'pdf/submissions', $oc->id ) }}"><i class="fa fa-plus"></i>Download</a>
                        </li>
                        <li>
                          <a href="{{ route( 'ocrdelete', $oc->id ) }}" class="btnSubDelete"><i class="fa fa-trash-o"></i>Delete</a>
                        </li> 
                        <li>
                          <a href="#" data-id="{{$oc->id}}" class="btnShare" data-toggle="modal" data-target="#shareModal2" data-link="{{ route( 'pdf/recommendation', $oc->id ) }}"><i class="fa fa-share "></i>Share</a>       
                        </li>

                      </ul>
                    </div>
                </td>

              </tr>
              @endforeach
              @foreach ( $pdf as $oc)
              <tr>
                <td>
                  {{ $oc->pdf }}
                </td>
                <td>
                  'N/A'
                </td>
                <td>
                 'N/A'&nbsp;
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($oc->created_at)) }}
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($oc->updated_at)) }}
                </td>
                <td>
                   
                   <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action<span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="{{ URL::to('/') }}/uploads/pdf/{{$oc->pdf}}"><i class="fa fa-plus"></i>Download</a>
                        </li>
                        <li>
                          <a href="{{ route( 'pdfdelete', $oc->id ) }}" class="btnSubDelete"><i class="fa fa-trash-o"></i>Delete</a>
                        </li> 
                        <li>
                          <a href="#" data-id="{{$oc->id}}" class="btnShare" data-toggle="modal" data-target="#shareModal2" data-link="{{ URL::to('/') }}/uploads/pdf/{{$oc->pdf}}"><i class="fa fa-share "></i>Share</a>       
                        </li>

                      </ul>
                    </div>
                </td>

              </tr>
              @endforeach
              @if (!$submissions->isEmpty())
              @foreach ( $submissions as $r)
              <tr id="{{$r->id}}" type="letter" formname="{{ $r->form()->first()->name }}">
                <td>
                  {{ $r->form()->first()->name }}
                </td>
                <td>
                {{ $r['writer']['first_name']}} &nbsp; {{ $r['writer']['last_name']}}
                </td>
                <td>
                  {{ $r->writer_email}}
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($r->created_at)) }}
                </td>
                <td>
                  {{ date("m/d/Y" , strtotime($r->updated_at)) }}
                </td>

                <td>

                  <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action<span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="{{ route( 'ranksub', $r->id ) }}"><i class="fa fa-star-o"></i>Ranking</a>
                        </li>
                        <li>
                          <a href="{{ route( 'pdf/submission', $r->id ) }}"><i class="fa fa-plus"></i>Download</a>
                        </li>
                        <li>
                          <a href="{{ route( 'submissiondelete', $r->id ) }}" class="btnSubDelete"><i class="fa fa-trash-o"></i>Delete</a>
                        </li>
                        <li>
                        <a href="{{ route( 'submission-update-view', $r->id ) }}"><i class="fa fa-refresh"></i>update</a>
                        </li> 
                        <li>
                          <a href="#" id="btnEditLetter" data-toggle="modal" data-target="#letterModal" data-id="{{$r->form()->first()->id}}"><i class="fa fa-edit"></i>Edit Letter Name</a>
                        </li> 
                        <li>
                          <a data-id="{{$r->id}}"  data-toggle="modal" data-target="#folderModal" class="addmodal"><i class="fa fa-folder-open-o"></i>Add to folder</a>
                        </li>
                        <li>
                          <a href="#" data-id="{{$r->id}}" class="btnShare" data-toggle="modal" data-target="#shareModal" data-link="{{URL::to("/")}}/forms/{{ $r->form()->first()->unique_id }}"><i class="fa fa-share "></i>Share</a>       
                        </li>

                      </ul>
                    </div>

                  <!-- <a href="{{ route( 'view/submission', $r->id ) }}"><button  class="btn btn-info">View</button></a> -->
<!--                   <a href="" class="btn btn-success">Ranking</a> -->
<!--                   <a href="{{ route( 'pdf/submission', $r->id ) }}" class="btn btn-primary">Download</a> -->
<!--                   <a href="#" data-id="{{$r->id}}" class="btn btn-success btnShare" data-toggle="modal" data-target="#shareModal" data-link="{{URL::to("/")}}/forms/{{ $r->form()->first()->unique_id }}">Share</a> -->
                 <!--  <a href="{{ route( 'report', $r->id ) }}" class="btn btn-info">Report</a> -->
<!-- 
                  <a data-id="{{$r->id}}"  data-toggle="modal" data-target="#folderModal" class="btn btn-danger addmodal">Add to folder</a> -->
                <!--   <a href="{{ route( 'submissiondelete', $r->id ) }}" class="btn btn-danger btnSubDelete">Delete</a> -->
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
         
        <a style="display:none" class="btn btn-lg btn-success pull-left" href="{{ URL::route('upload-form')}}">Upload Ocr</a>
        <a class="btn btn-lg btn-success pull-left" href="{{ URL::route('upload-form-pdf')}}">Upload Letter</a>
        <a class="btn btn-lg btn-success pull-left" href="{{ URL::route('linkedin')}}">Get recommendation from LinkedIn</a>
      </div>

    </div>

  </div>
  <!-- end Responsive Table -->
</div>
<br>
<div class="page-title">
  <h1>
    Folders
  </h1>

</div>
<div class="clearfix"></div>
<div class="row">

  <!-- Basic Table -->
  <div class="col-lg-12">
      <div class="widget-container fluid-height clearfix">
              <div class="widget-content padded clearfix">
                @if (!$requests->isEmpty())
                  <div class="table-responsive">
                    <table class="table tblFolders">
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
                        <th>
                          Actions
                        </th>
                      </thead>
                      <tbody>
                        @foreach ( $folder as $r)
                        <tr id="{{$r->id}}">
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
                            
                            <div class="btn-group">
                              <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action<span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                <li>
                                  <a href="{{ route( 'folder_submissions', $r->id ) }}"><i class="fa fa-folder-open-o"></i> View</a> 
                                </li>
                                <li>
                                  <a href="" id="btnEditFolder" data-toggle="modal" data-target="#folderReModal" data-id="{{$r->id}}"><i class="fa fa-edit"></i> Edit Folder Name</a>
                                </li> 
                                <li>
                                  <a href="" data-id="{{$r->id}}" class="btnShare" data-toggle="modal" data-target="#shareModal" data-link="{{route('public_folder_submissions',$r->id)}}" ><i class="fa fa-share"></i> Share</a>
                                </li>
                                <li>
                                 <a href="{{ route( 'folder-ranking', $r->id ) }}"><i class="fa fa-star"></i> Folder Ranking</a>

                               </li>
                             </ul>
                            </div>
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



@endif

<div id="folderModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Add to Folder</h4>
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
      <form id="formfolder">
        <div class="modal-body">

         <select id="folder_id" name="folder_id" class="form-control">
         <option value="New">New Folder</option>
           @foreach($folder as $f)
           <option value="{{$f->id}}">

             {{ $f->folder_name }}
           </option>

           @endforeach
         </select>
       </div>
     </form>
     <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <button type="button" id="btnAddtoFolder" class="btn btn-primary">Add</button>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->




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
          <button type="button" class="btn btn-primary btnShareSubmit">Share</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<div id="shareModal2" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Share</h4>
      </div>
      <div class="modal-body">
       <form class="form-horizontal" onsubmit="return false;" action="" method="post" id="formShareSubmitOcr">
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
          <button type="button" class="btn btn-primary btnShareSubmitOcr">Share</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<div id="shareModal3" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Share</h4>
      </div>
      <div class="modal-body">
       <form class="form-horizontal" onsubmit="return false;" action="" method="post" id="formfol">
        <div class="form-group">
          <label class="control-label col-md-2">Name</label>
          <div class="col-md-7">
            <input  placeholder="" email name="folder_name" id="folder_name"  type="text"  class="form-control"  />
          </div>
          <div class="clearfix"></div>
 
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
     
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary btnfoldSave">Save</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

<!-- edit letter name modal -->
<div id="letterModal" class="modal fade">
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
      <form id="formEditLetter">
        <div class="modal-body">
          <label>New Name</label><input type="text" name="rname" class="form-control">
          <input type="text" style="display:none" id="hdnformid" />
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnRename" class="btn btn-primary">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



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
          <input type="text" class="form-control" id="folder_name_f" placeholder="Enter folder name">
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
  $('.btnShare').click(function() {
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

    var folder_name = $("#folder_name_f").val();
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

  $('.addmodal').click(function() {

    window.resquestid=$(this).data('id');
  
  });
   $('.addmodals').click(function() {

     window.resquestid=$(this).data('id');
    window.submission_type = $(this).data('type');

  });
  $('.btnfoldSave').click(function(){
           
     $('#folderModal').modal('hide');
     window.folder_name=$('#folder_name').val();
     console.log(window.folder_name);
     var data ='folder_name='+window.folder_name+'&folder_id=0';

    if(window.submission_type == null || window.submission_type == 'undefined')
    {

      window.submission_type="empty";
    }
    
    console.log(window.resquestid);
    console.log(window.submission_type);
    
    $.ajax({
      url: baseUrl+'/ajax/addtofolder',
      method:'post',
      data: data+'&request_id='+window.resquestid+'&submission_type='+window.submission_type,
      success: function(data){
        if(data.status=="success")
        {

          $('.successMsgSh').html('Added to folder').show();
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
  
  $('#btnAddtoFolder').click(function() {
    

    if($('#folder_id').val()=='New')
    {

      console.log('New');
      $('#shareModal3').modal('show');
       
    }
    else
    {
      window.folder_name="";
    console.log('test');
    var data = $("#formfolder").serialize();

    if(window.submission_type == null || window.submission_type == 'undefined')
    {

      window.submission_type="empty";
    }
    
    console.log(window.resquestid);
    console.log(window.submission_type);
    $.ajax({
      url: baseUrl+'/ajax/addtofolder',
      method:'post',
      data: data+'&request_id='+window.resquestid+'&submission_type='+window.submission_type,
      success: function(data){
        if(data.status=="success")
        {

          $('.successMsgSh').html('Added to folder').show();
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

  }
    return false;
  });

  $('.btnShareSubmit').click(function() {



   var data = $("#formShareSubmit").serialize();
   var pdf=$(".sharelink").html();
       console.log(pdf);
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
  $('.btnShareSubmitOcr').click(function() {



   var data = $("#formShareSubmitOcr").serialize();
   var pdf=$(".sharelink").html();
       console.log(pdf);
      data = data+'&pdf='+pdf;
      $.ajax({
        url: baseUrl+'/ajax/shareOcr',
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

@section('js')
<script src="{{URL::asset('assets/js/alertify.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(function(){


    $('.btnSubDelete').click(function(evt){
      var btnObj = $(this);
     alertify.confirm("Are you sure ?", function (e) {
      if (e) {
        alertify.success("Deleted Successfully");
        location.href = btnObj.attr('href');
        return true;
      } else {
        alertify.error("Deletion aborted");
        return false;
      }
    });
     evt.preventDefault();
   });
   
   $('#btnEditLetter').click(function(){
    
    // alert($(this).data('id'));
    $('#hdnformid').val($(this).data('id'));

    
   });

   $('#btnRename').click(function(){

    var data = $("#formEditLetter").serialize();
    var hdnformid = $('#hdnformid').val(); 
    data = data;
    $.ajax({
      url: baseUrl+'/ajax/edit-letter-name',
      method:'post',
      data: data+'&form_id='+hdnformid,
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

    $( ".tblSubmisssion tr" ).draggable({
      appendTo: "body",
       helper: function (e, ui) {
        return $(this).clone(true).html("<div class='ondragDiv' >"+$(this).attr('formname')+'</div>'); //Replaced $(ui) with $(this)
      },
      start: function(event, ui) { 
           
       },
     
    });

    $('.tblFolders tbody tr').droppable({
      accept: ".tblSubmisssion tr",
      activeClass: "ui-state-hover",
      hoverClass: "ui-state-active",
      over: function(event, ui) {

       $(this).addClass('hover-drop');


     },
     out: function(event, ui) {
       $(this).removeClass('hover-drop');
     },    
     drop: function( event, ui ) {
       var letter_type    = ui.draggable.attr('type');
       var letter_id      = ui.draggable.attr('id');
       var drop_folder_id = $(this).attr('id');
     

       console.log('letter_type=',letter_type);
       console.log('letter_id=',letter_id);
       console.log('drop_folder_id=',drop_folder_id);
       if(letter_type == null || letter_type == 'undefined')
       {
       
        $('.drop-alert-box-not').fadeIn('slow');

        $(this).removeClass('hover-drop');

        $('.drop-alert-box-not').delay(3500).fadeOut('slow');

        return false;
       }
       window.folder_name="";
       console.log('test');
       var data = 'folder_id='+drop_folder_id;

       if(letter_type == null || letter_type == 'undefined')
       {

        window.submission_type="empty";
      }
      window.resquestid=letter_id;
      console.log(window.resquestid);
      console.log(window.submission_type);
      $.ajax({
        url: baseUrl+'/ajax/addtofolder',
        method:'post',
        data: data+'&request_id='+window.resquestid+'&submission_type='+window.submission_type,
        success: function(data){
          if(data.status=="success")
          {

            $('.drop-alert-box').fadeIn('slow');

            $(this).removeClass('hover-drop');

            $('.drop-alert-box').delay(3500).fadeOut('slow');

          }
          else
          {

          }
        },
        dataType: 'json'
      });


     }
   });

  });
</script>
@stop