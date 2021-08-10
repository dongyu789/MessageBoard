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

<form action="/index/testGetSession" method="post">
    <input type="hidden" name="_token" value="{{csrf_token()}}">

    用户 ： <input type="text" name="username" >
    <br>
    <br>
    密码 ： <input type="password" name="pwd">
    <br>
    <br>

    <button type="submit">登录</button>
</form>
</body>
</html>