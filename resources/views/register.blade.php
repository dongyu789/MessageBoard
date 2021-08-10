
@extends('public.base')
@section('title','注册')

@section('title_2', "注册")

@section('mybody')
    <form action="/index/registerOver" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        用户 ： <input type="text" name="username" >
        <br>
        <br>
        密码 ： <input type="password" name="pwd">
        <br>
        <br>
        确认密码 : <input type="password" name="pwd_confirmation">
        <br>
        <br>
        <button type="submit">开始注册</button>
    </form>

    注意：
    <br>
    1 用户名必须是数字
    <br>
    2 密码只可以是数字、字母、下划线
    <br>
    3 用户名和密码长度必须在6-8个字符
    <br>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <h3>
                <br>
                {{$error}}
                <br>
            </h3>
        @endforeach
    @endif

@endsection
