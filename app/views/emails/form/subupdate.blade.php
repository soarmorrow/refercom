<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>User requested</h2>

		<div>
			{{$data['user']}} has requested you to fill the updated form.
			please update this form: {{ route('writer-form', $data['request_id']) }}.
		</div>
	</body>
</html>