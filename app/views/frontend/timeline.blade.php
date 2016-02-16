@extends('frontend/layouts/default')


 @section('js')
 <script src="{{URL::asset('assets/js/timeline.js')}}" type="text/javascript"></script>
  <script src="{{URL::asset('assets/javascripts/fitvids.js')}}" type="text/javascript"></script>


 @stop

@section('content')
<div class="container-fluid main-content">
  <div class="page-title">
    <h1>
      Timeline
    </h1>
  </div>


        




  <ul class="timeline animated">

    @foreach($timeline as $timelin)
    
    @if($timelin->activity_type === 'new-form')

    <li>
      <div class="timeline-time">
        <!-- <strong>Oct 3</strong>4:53 PM -->
       <strong>{{ date("d F Y",strtotime($timelin['updated_at'])) }}</strong> 
      </div>
      <div class="timeline-icon">
        <div class="bg-success">
          <i class="fa fa-pencil"></i>
        </div>
      </div>
      <div class="timeline-content">
        <h2>

         {{ $timelin->form()->first()->name }} is <i>created</i> by {{$timelin['seeker']}} 
        </h2>
        <p>
         New form is created and saved as {{ $timelin->form()->first()->name }} by {{$timelin['seeker']}} 
        </p>
      </div>
    </li>
   
   @elseif($timelin['activity_type'] === 'request-form')
    <li>
      <div class="timeline-time">
           <strong>{{ date("d F Y",strtotime($timelin['updated_at'])) }}</strong> 
      </div>
      <div class="timeline-icon">
        <div class="bg-muted">
          <i class="fa fa-pencil"></i>
        </div>
      </div>
      <div class="timeline-content">
        <h2>
         {{ $timelin->form()->first()->name }} is <i>requested</i> from {{$timelin['writer']}}.
        </h2>
        <p>
         Letter requested from {{$timelin['writer']}}. 
        </p>
      </div>
    </li>
 

     @elseif($timelin['activity_type'] === 'submit-form')
    <li>
      <div class="timeline-time">
           <strong>{{ date("d F Y",strtotime($timelin['updated_at'])) }}</strong> 
      </div>
      <div class="timeline-icon">
        <div class="bg-primary">
          <i class="fa fa-pencil"></i>
        </div>
      </div>
      <div class="timeline-content">
        <h2>
         {{ $timelin->form()->first()->name }} is <i>submitted</i>
        </h2>
        <p>
         Letter by {{$timelin['writer']}}. 
        </p>
      </div>
    </li>


     @elseif($timelin['activity_type'] === 'share-Form')
    <li>
      <div class="timeline-time">
          
          <strong>{{ date("d F Y",strtotime($timelin['updated_at'])) }}</strong> 
      </div>
      <div class="timeline-icon">
        <div class="bg-warning">
          <i class="fa fa-pencil"></i>
        </div>
      </div>
      <div class="timeline-content">
        <h2>
          {{ $timelin->form()->first()->name }} is <i>shared</i>
        </h2>
        <p>
          {{ $timelin->form()->first()->name }} is shared to <strong>{{{$timelin->shared_email}}}</strong> after submission.
        </p>
      </div>
    </li>
    @endif
    @endforeach
     <!-- <li>
      <div class="timeline-time">
        <strong>Oct 5</strong>6:14 PM
      </div>
      <div class="timeline-icon">
        <div class="bg-warning">
          <i class="fa fa-quote-right"></i>
        </div>
      </div>
      <div class="timeline-content">
        <blockquote>
          <p>
            Lorem ipsum velit ullamco anim pariatur proident eu deserunt laborum. Lorem ipsum ad in nostrud adipisicing cupidatat anim officia ad id cupidatat veniam quis elit ullamco.
          </p>
          <small>John Smith</small></blockquote>
        </div>
      </li>

      <li>
        <div class="timeline-time">
          <strong>Oct 6</strong>9:00 AM
        </div>
        <div class="timeline-icon">
          <div class="bg-info">
            <i class="fa fa-camera"></i>
          </div>
        </div>
        <div class="timeline-content image">
          <h2>
            This is an image posted on my timeline
          </h2>
          <img src="images/img-coast.jpg" />
          <p>
            Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 8</strong>2:01 PM
        </div>
        <div class="timeline-icon">
          <div class="bg-danger">
            <i class="fa fa-pencil"></i>
          </div>
        </div>
        <div class="timeline-content">
          <h2>
            This is a title for this timeline post
          </h2>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
          <p>
            Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.
          </p>
          <p>
            Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 11</strong>10:33 AM
        </div>
        <div class="timeline-icon">
          <div class="bg-success">
            <i class="fa fa-camera"></i>
          </div>
        </div>
        <div class="timeline-content">
          <h2>
            This is a title for this timeline post
          </h2>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 12</strong>1:14 PM
        </div>
        <div class="timeline-icon">
          <div class="bg-primary">
            <i class="fa fa-video-camera"></i>
          </div>
        </div>
        <div class="timeline-content video">
          <h2>
            This is a title for this timeline post
          </h2>
          <iframe allowfullscreen="" frameborder="0" mozallowfullscreen="" src="http://player.vimeo.com/video/16202331?title=0&amp;byline=0&amp;portrait=0" webkitallowfullscreen=""></iframe>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 18</strong>8:45 AM
        </div>
        <div class="timeline-icon">
          <div class="bg-warning">
            <i class="fa fa-pencil"></i>
          </div>
        </div>
        <div class="timeline-content">
          <h2>
            Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing
          </h2>
          <p>
            Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 21</strong>9:55 AM
        </div>
        <div class="timeline-icon">
          <div class="bg-success">
            <i class="fa fa-clock-o"></i>
          </div>
        </div>
        <div class="timeline-content">
          <h2>
            This is a title for this timeline post
          </h2>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 6</strong>9:00 AM
        </div>
        <div class="timeline-icon">
          <div class="bg-info">
            <i class="fa fa-camera"></i>
          </div>
        </div>
        <div class="timeline-content image">
          <h2>
            This is an image posted on my timeline
          </h2>
          <img src="images/img-coast.jpg" />
          <p>
            Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 8</strong>2:01 PM
        </div>
        <div class="timeline-icon">
          <div class="bg-danger">
            <i class="fa fa-pencil"></i>
          </div>
        </div>
        <div class="timeline-content">
          <h2>
            This is a title for this timeline post
          </h2>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
          <p>
            Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.
          </p>
          <p>
            Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 11</strong>10:33 AM
        </div>
        <div class="timeline-icon">
          <div class="bg-success">
            <i class="fa fa-camera"></i>
          </div>
        </div>
        <div class="timeline-content">
          <h2>
            This is a title for this timeline post
          </h2>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 12</strong>1:14 PM
        </div>
        <div class="timeline-icon">
          <div class="bg-primary">
            <i class="fa fa-video-camera"></i>
          </div>
        </div>
        <div class="timeline-content video">
          <h2>
            This is a title for this timeline post
          </h2>
          <iframe allowfullscreen="" frameborder="0" mozallowfullscreen="" src="http://player.vimeo.com/video/16202331?title=0&amp;byline=0&amp;portrait=0" webkitallowfullscreen=""></iframe>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 18</strong>8:45 AM
        </div>
        <div class="timeline-icon">
          <div class="bg-warning">
            <i class="fa fa-pencil"></i>
          </div>
        </div>
        <div class="timeline-content">
          <h2>
            Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing
          </h2>
          <p>
            Morbi interdum mollis sapien. Sed ac risus. Phasellus lacinia, magna a ullamcorper laoreet, lectus arcu pulvinar risus, vitae facilisis libero dolor a purus. Sed vel lacus. Mauris nibh felis, adipiscing varius, adipiscing in, lacinia vel, tellus. Suspendisse ac urna. Etiam pellentesque mauris ut lectus. Nunc tellus ante.
          </p>
        </div>
      </li>
      <li>
        <div class="timeline-time">
          <strong>Oct 21</strong>9:55 AM
        </div>
        <div class="timeline-icon">
          <div class="bg-success">
            <i class="fa fa-clock-o"></i>
          </div>
        </div>
        <div class="timeline-content">
          <h2>
            This is a title for this timeline post
          </h2>
          <p>
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.
          </p>
        </div>
      </li> -->
    </ul>
  </div>
@stop