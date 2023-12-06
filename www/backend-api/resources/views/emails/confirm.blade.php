<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

Уважаемый клиент, {{ $name  }}!
<br>
Подтвердите Ваш email нажав на ссылку ниже:
<a href="http://api.passmem.local/confirm_email/{{$code}}">confirm</a>

</body>
</html>
