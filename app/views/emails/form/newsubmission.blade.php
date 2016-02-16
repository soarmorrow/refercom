<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Your letter is done</h2>

		<div>
			Hi {{$first_name}}&nbsp;{{$last_name}},
			{{$data['user']}} has finished a letter for you. To check it out, please <a href="{{$link}}">click here</a>.
			
			Thanks,
			Referecom Team
		</div>
	</body>
</html>