
@extends('public.base')
@section('title','查看留言')

@section('title_2', '查看留言')
@section('username', $username)
@section('mybody')
    @if($username == '游客')
        <center><h1>游客<a href="/index/login">登录</a> 后查看每条留言的评论</h1></center>
        <br>
    @endif

    @foreach($messages as $message)
        <br>
        <table border="1">
            <tr>
                <td>
                    用户 ： {{$message->user_id}}
                </td>
                <td>发帖时间 ： {{$message->created_at}}</td>
                <td>修改时间 ： {{$message->updated_at}}</td>
                @if ($username != '游客')
                    <td>
                        <form action="/index/commentBegin" method="post" >
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="message_id" value="{{$message->id}}">
                            <button type="submit">查看评论</button>
                        </form>
                    </td>
                @endif
            </tr>
            <tr>
                <td>{{$message->message}}</td>
            </tr>
        </table>
        <br>


    @endforeach

{{$messages->links()}}

@endsection