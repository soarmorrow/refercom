<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>A letter recieved</h2>
		<div>
		@if($status == 'complete')
			Today is the deadline of your request and it is completed and you could see it here.
			{{route('all/submissions')}}
			or
			{{route('forms')}}
		@else
			Today is the deadline of your request and it is not yet submitted.
			or
			{{route('forms')}}
		@endif
		</div>
		<div>
		
		</div>
	</body>
</html>