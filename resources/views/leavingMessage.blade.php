
@extends('public.base')
@section('title','留言')

@section('title_2', '留言')
@section('username', $username)
@section('mybody')
    <form action="/index/leavingMessageOver" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <br>
        <br>
        写留言 ：
        <br>
        <textarea rows="3" cols="20" name="message" >{{$message}}</textarea>
        <br>
        <br>
        <br>
        <br>

        <button type="submit">提交</button>
    </form>
    <br>
    <br>
    <a href="/index/receiveVideo">进入语音留言</a>
    <br>
    <br>
{{--    <form action="/index/viewMessage" method="post">--}}
{{--        <input type="hidden" name="_token" value="{{csrf_token()}}">--}}
{{--        <button type="submit">查看所有留言</button>--}}
{{--    </form>--}}
    <a href="/index/viewMessage">查看所有留言</a>
    <br>
    <br>
    <br>
    <br>
{{--    <form action="/index/viewMyselfMessage" method="post">--}}
{{--        <input type="hidden" name="_token" value="{{csrf_token()}}">--}}
{{--        <button type="submit">查看我自己的留言</button>--}}
{{--    </form>--}}
    <a href="/index/viewMyselfMessage">查看我自己的留言</a>

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