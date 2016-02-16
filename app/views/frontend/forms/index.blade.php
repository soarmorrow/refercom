@extends('frontend/layouts/default')

<?php $statusLabels = array('active' => 'success' ,'archive' => 'warning' , 'unsaved' => 'danger' ); ?>

{{-- Page content --}}
@section('content')


  <div class="page-title">
    <h1>
    Forms
    </h1>
  </div>
  <div class="row">
    <!-- Basic Table -->

    <div class="col-lg-12">
            <div class="widget-container fluid-height clearfix">
              <div class="heading">
                <a class="btn btn-lg btn-success pull-right" href="{{ URL::route('new/form') }}">New Form</a>
                 <a class="btn btn-lg btn-info pull-right" href="{{ URL::route('new/posting') }}">New Posting</a>
              </div>
              <!-- Notifications -->
        @include('frontend/notifications')

              <div class="widget-content padded clearfix">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <th>
                        Name
                      </th>
                      <th>
                        Description
                      </th>
                      <th>
                        Unique_Id
                      </th>
                      <th>
                        Created At
                      </th>
                      <th>
                        Type
                      </th>
                      <th>
                        Requests
                      </th>
                      <th>
                        Submissions
                      </th>
                      <th>
                        Status
                      </th>
                      <th>
                        Actions
                      </th>
                    </thead>
                    <tbody>
                      @foreach ( $forms as $f)
                      <tr>
                        <td>
                          {{ $f->name}}
                        </td>
                        <td>
                          {{ $f->description }}
                        </td>
                        <td>
                         
                           @if($f->type == 'posting')
                             <a href="{{ route('edit-posted-skills', $f->id) }}" >{{ $f->unique_id }}</a>
                           @else
                             <a href="{{ route('edit/form', $f->id) }}" >{{ $f->unique_id }}</a>
                           @endif
                        </td>
                        <td>
                          {{ date("m/d/Y" , strtotime($f->created_at))}}
                        </td>
                        <td>
                          {{ $f->type }}
                        </td>
                        <td>
                          {{ $f->requests()->count() }}
                        </td>
                        <td>
                         <a href="{{ route('submissions/form', $f->id) }}"> {{ route('submissions/form', $f->id) }}</a>
                        </td>
                        <td>
                          <span class="label label-{{ $statusLabels[ $f->status ] }}">{{ $f->status }}</span>
                        </td>
                        <td>

                        
                        @if($f->submissions->first()["submission_status"])
                          @if($f->status == 'active')
                          <a href="{{ route( 'rank', $f->id ) }}" class="btn btn-success">Ranking</a>
                         @endif
                        @endif
                          <div class="btn-group">
                      <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">Action<span class="caret"></span></button>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="{{ route('send/form', $f->id) }}"><i class="fa fa-plus"></i>Send Form</a>
                        </li>
                        <li>
                          <a href="{{ route('requests/form', $f->id) }}"><i class="fa fa-plus"></i>View Sent Requests</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                          <a href="{{ route('submissions/form', $f->id) }}"><i class="fa fa-edit"></i>Submissions</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                          <a href="{{ route('activate/form', $f->id) }}"><i class="fa fa-trash-o"></i>Activate</a>
                        </li>
                        <li>
                          <a href="{{ route('archive/form', $f->id) }}"><i class="fa fa-trash-o"></i>Archive</a>
                        </li>
                        <li>
                          <a href="{{ route('edit/form', $f->id) }}"><i class="fa fa-pencil-square-o "></i>Edit</a>
                        </li>
                        <li>
                          <a href="{{ route('delete/form', $f->id) }}"><i class="fa fa-trash-o"></i>Delete</a>
                        </li>
                      </ul>
                    </div>
                        </td>
                      </tr>
                      @endforeach

                      <tr>
                        <td align="center" colspan="9">
                            user submitted forms
                        </td>
                      </tr>

                        @foreach ( $indforms as $f)
                      <tr>
                        <td>
                          {{ $f->name}}
                        </td>
                        <td>
                          {{ $f->description }}
                        </td>
                        <td>
          
                             <a href="{{ route('edit/form', $f->id) }}" >{{ $f->unique_id }}</a>
                      
                        </td>
                        <td>
                          {{ date("m/d/Y" , strtotime($f->created_at))}}
                        </td>
                        <td>
                          {{ $f->type }}
                        </td>
                        <td>
                          {{ $f->requests()->count() }}
                        </td>
                        <td>
                         <a href="{{ route('submissions/form', $f->id) }}"> {{ route('submissions/form', $f->id) }}</a>
                        </td>
                        <td>
                          <span class="label label-{{ $statusLabels[ $f->status ] }}">{{ $f->status }}</span>
                        </td>
                        <td>

                        
                        @if($f->submissions->first()["submission_status"])
                          @if($f->status == 'active')
                          <a href="{{ route( 'rank', $f->id ) }}" class="btn btn-success">Ranking</a>
                         @endif
                        @endif
                        </td>
                      @endforeach
                    </tbody>
                  </table>
                </div>
     
              </div>


            </div>
          </div>
          <!-- end Responsive Table -->
  </div>

@stop