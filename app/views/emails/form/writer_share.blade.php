<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>A letter recieved</h2>
		<div>
			{{ $data['writer_email'] }} send a form from {{ $data['seeker_name'] }}..Please see below
		</div>
		<div>
			{{ $link }}
		</div>
	</body>
</html>