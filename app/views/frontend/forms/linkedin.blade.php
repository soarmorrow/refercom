@extends('frontend/layouts/default')

@section('css')


@stop
@section('js')



 @stop

@section('content')
<div class="container-fliud" style="background-color:white">

  <!-- Notifications -->
  @include('frontend/notifications')

  <form method="post" action="{{ route('linkedin/save') }}">

    @if($recommendations['_total'] > 0)
      
      @foreach($recommendations['values'] as $r)
        <div class="row">
          <div class="col-md-12">
            <input type="radio" name="id" value="{{ $r['id'] }}">
            By {{ $r['recommender']['firstName'] . ' ' . $r['recommender']['lastName'] }}
            <p>
              {{ $r['recommendationText']}}
            </p>
          </div>
        </div>

      @endforeach
    @else
        <div class="alert alert-warning">No recommendations found</div>

    @endif

    <div class="padded container-fliud">
        <input type="hidden" name="_token" value="{{ csrf_token()}}"/>
     		<input type="submit" class="btn btn-lg btn-success" {{ ($recommendations['_total'] == 0) ? 'disabled' : '';}} value="Save" />
     	
    </div>
  </form>
</div>
@stop