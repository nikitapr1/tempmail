<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Временная почта</title>
</head>
<body>
@if(!empty($address))
    <p>Ваш временный почтовый адрес: {{$address}}</p>
@elseif(!empty($errorMessage))
    <p>{{$errorMessage}}</p>
@else
    <p>Неизвестная ошибка</p>
@endif
<br>
@foreach($emails as $email)
    <div>
        {{date('Y.m.d H:i:s', strtotime($email->date))}}
        <br>
        От: {{$email->from}}
        <br>

        <b>{{$email->subject}}</b>
        <br>
        <div style="padding-left: 10px; padding-right: 10px">
            {!!$email->body!!}
        </div>
        <hr>
    </div>
@endforeach


</body>
</html>
