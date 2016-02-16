@extends('frontend/layouts/default')

<?php $except = array('id', 'form_request_id' , 'created_at' , 'updated_at' , 'confirm'); ?>
<?php $view_fields = array( 'textarea' , 'textfield' , 'checkbox' , 'dropdown', 'radio'); ?>

{{-- Page content --}}
@section('content')

<div class="page-title">
  <h1>
    Letter Submission
  </h1>
</div>
<div class="row">
  <!-- Basic Table -->
  <div class="col-lg-6">
    <div class="widget-container fluid-height clearfix">
      <div class="heading">
        <i class="fa fa-table"></i>Your Information
      </div>
      <div class="widget-content padded clearfix">
        <table class="table">
          <thead>
            <tbody>
              <tr>
                <th>
                  Email
                </th>
                <td>
                  {{$request->seeker_email}}
                </td>
              </tr>
              @foreach ($seeker as $key => $value)
              @if(!in_array( $key , $except ))
              <tr>
                <th>
                  {{ucfirst(str_replace('_' , ' ' , $key))}}
                </th>
                <td>
                  {{$value}}
                </td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end Basic Table --><!-- Bordered Table -->
    <div class="col-lg-6">
      <div class="widget-container fluid-height clearfix">
        <div class="heading">
          <i class="fa fa-table"></i>Writer Information
        </div>
        <div class="widget-content padded clearfix">
          <table class="table">
            <thead>
              <tbody>
                <tr>
                  <th>
                    Email
                  </th>
                  <td>
                    {{$request->writer_email}}
                  </td>
                </tr>
                @foreach ($writer as $key => $value)
                @if(!in_array( $key , $except ))
                <tr>
                  <th>
                    {{ucfirst(str_replace('_' , ' ' , $key))}}
                  </th>
                  <td>
                    {{$value}}
                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- end Bordered Table -->
    </div>
  <div class="row">
  <!-- Basic Table -->
  <div class="col-lg-6">
    <div class="widget-container fluid-height clearfix">
      <div class="heading">
        <i class="fa fa-table"></i>Writer Submmissions
      </div>
      <div class="widget-content padded clearfix">
        <table class="table">
          <thead>
            <tbody>
              @foreach( $fields as $f)
              @if(in_array( $f->type , $view_fields ))
              <tr>
                <th>
                  {{$f->label}}
                </th>
                <td>
                  @if(!$f->submission()->get()->isEmpty())
                    {{ $f->submission()->first()->option}}
                  @endif
                </td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
    <div class="widget-container fluid-height clearfix">
      <div class="heading">
        <i class="fa fa-table"></i>Writer Sharings
      </div>
      <div class="widget-content padded clearfix">
        <table class="table">
          <thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
      <!-- end Bordered Table -->
    </div>

   @stop