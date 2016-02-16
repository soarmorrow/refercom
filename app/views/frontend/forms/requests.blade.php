@extends('frontend/layouts/default')

<?php $statusLabels = array('active' => 'success' ,'resent' => 'warning' , '' => 'warning','complete' => 'primary' ); ?>



{{-- Page content --}}
@section('content')

  <div class="page-title">
    <h1>
    Letter requests
     <a class="btn btn-lg btn-success pull-right" href="{{ URL::route('new/form') }}">New Request</a>
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
                    <table class="table">
                      <thead>
                        <th>
                          Form
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

@stop