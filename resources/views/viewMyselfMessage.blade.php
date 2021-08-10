
@extends('public.base')
@section('title','查看我自己的留言')

@section('title_2','查看我自己的留言')
@section('username', $username)
@section('mybody')

    @foreach($messages as $message)
        <br>
        <table border="1">
            <tr>
                <td>用户 ： {{$message->user_id}}</td>
                <td>发帖时间 ： {{$message->created_at}}</td>
                <td>修改时间 ： {{$message->updated_at}}</td>
                <td>
                    <form action="/index/updateMessage" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="message_id" value="{{$message->id}}">
                        <input type="hidden" name="old_message" value="{{$message->message}}">
                        <button type="submit">编辑</button>
                    </form>
                </td>
                <td>
                    <form action="/index/deleteMessage" method="get">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="message_id" value="{{$message->id}}">

                        <button type="submit">删除</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>{{$message->message}}</td>
            </tr>
        </table>
        <br>


@endforeach

    {{$messages->links()}}

@endsection