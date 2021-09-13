
@extends('public.base')
@section('title','查看留言')

@section('title_2', '查看留言')
@section('username', $username)

@section('user')
    登陆次数:{{$loginCount}}
    <br>
    发帖数:{{$messageCount}}
    <br>
    被访问数:{{$viewCount}}
@endsection
@section('mybody')
    @if($username == '游客')
        <center><h1>游客<a href="/index/login">登录</a> 后查看每条留言的评论</h1></center>
        <br>
    @endif

    <h2>输入关键字搜索留言：</h2>
{{--    跳转到es检索功能，然后返回到本页--}}
    <form action="/index/search" method="get">
        <input type="text" name="tags">
        <button type="submit">搜索</button>
    </form>

    <br>
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
                <td colspan="5"><pre>{{$message->message}}</pre></td>
            </tr>
        </table>
        <br>


    @endforeach

{{$messages->links()}}

@endsection