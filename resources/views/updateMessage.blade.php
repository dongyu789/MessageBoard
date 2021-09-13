
@extends('public.base')
@section('title', '更新留言')

@section('title_2', '更新留言')
@section('username', $username)
@section('mybody')

    <form action="/index/updateMessageOver" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="message_id" value="{{$message_id}}">
        留言 ：<br>
{{--        <pre><input type="text" name="new_message" value="{{$old_message}}"></pre>--}}
        <textarea rows="25" cols="60" name="new_message" >{{$old_message}}</textarea>
        <br>
        <br>

        <button type="submit">确定</button>
    </form>
@endsection