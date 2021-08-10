
@extends('public.base')
@section('title', '注销')

@section('title_2', '注销')

@section('mybody')

    <form action="/index/cancellationOver" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        用户 ： <input type="text" name="username" >
        <br>
        <br>
        密码 ： <input type="password" name="pwd">
        <br>
        <br>

        <button type="submit">注销</button>
    </form>

@endsection
