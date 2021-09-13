
@extends('public.base')
@section('title','留言')

@section('title_2', '留言')
@section('username', $username)
@section('mybody')
    <a href="" >我收到的消息</a>
    <br>
    <br>
    <a href="/index/receiveVideo">进入语音留言</a>
    <form action="/index/leavingMessageOver" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <br>
        <br>
        写留言 ：（右下角拖动可以放大窗口）
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

    <br>
    <br>
{{--    <form action="/index/viewMessage" method="post">--}}
{{--        <input type="hidden" name="_token" value="{{csrf_token()}}">--}}
{{--        <button type="submit">查看所有留言</button>--}}
{{--    </form>--}}


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