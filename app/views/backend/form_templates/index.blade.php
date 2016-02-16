@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
User Management ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Form template management

		<div class="pull-right">
			<a href="{{ route('create/form-template') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>

		</tr>
	</thead>
	<tbody>

	</tbody>
</table>


@stop
