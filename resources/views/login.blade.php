
@extends('public.base')
@section('title','登录')
@section('title_2','登录')
@section('mybody')



    <form action="/index/loginOver" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        用户 ： <input type="text" name="username" value="{{old('username')}}">
        <br>
        <br>
        密码 ： <input type="password" name="pwd">
        <br>
        <br>

        <button type="submit">登录</button>
    </form>
    <br>
    <br>


    <a href="/index/register">注册</a>


    <a href="/index/cancellation">注销</a>


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
