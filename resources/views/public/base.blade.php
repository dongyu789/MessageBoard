<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MessageBoard---@yield('title','留言板')</title>

</head>
<body>
你好,@yield('username','游客')
<br>
 <a href="/index/quit">退出</a>
<br><br>
<a href="/index/leavingMessage">返回留言</a>
<a href="/index/viewMyselfMessage">查看我自己的留言</a>
<a href="/index/viewMessage">查看所有留言</a>
<center>


<h1>
    一个留言板
    <br>
    <br>
    @yield('title_2')页面
</h1>
<br>
<br>

@yield('mybody')

</center>
</body>
</html>