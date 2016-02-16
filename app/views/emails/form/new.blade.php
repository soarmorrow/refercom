<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>New letter request</h2>

		<div>
		    Hi {{$data['writer-firstname']}} &nbsp; {{$data['writer-lastname']}},
		    {{$data['user']}} has requested a letter of recommendation from you.
		    To get started, please <a href="{{ route('writer-form', $data['request_id']) }}">click here</a>
             
		    Thanks,
		    Referecom Team			
		</div>
	</body>
</html>