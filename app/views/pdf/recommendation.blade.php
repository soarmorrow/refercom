<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <h3>
      Recommendation for {{ $user->first_name.' '. $user->last_name }}
  </h3>
  <p>By : {{ $recommendation->recommended_by }}</p>
  <p> {{ $recommendation->by_headline }}<p>
  <br/>
  <p>Engagement : <b>{{ $recommendation->user_position }}</b></p>
  <p>At : <b>{{$recommendation->user_company}}</b></p>
  <br/>

  <p>{{ $recommendation->recommend_text }}</p>

</body>
</html>