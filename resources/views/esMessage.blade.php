
@extends('public.base')
@section('title','检索留言')

@section('title_2', '检索留言')
@section('username', $username)
@section('mybody')
    @if($username == '游客')
        <center><h1>游客<a href="/index/login">登录</a> 后查看每条留言的评论</h1></center>
        <br>
    @endif

    <h2>输入关键字搜索留言：</h2>
    {{--    跳转到es检索功能，然后返回到本页--}}
    <form action="/index/search" method="get">
        <input type="text" name="tags" value="{{old('tags')}}">
        <button type="submit">搜索</button>
    </form>

    <br>
    @foreach($datas as $data)
        <br>
        <table border="1">
            <tr>
                <td>
                    用户 ： {{$data['user_id']}}
                </td>
{{--                <td>发帖时间 ： {{"无"}}</td>--}}
{{--                <td>修改时间 ： {{"无"}}</td>--}}
                @if ($username != '游客')
                    <td>
                        <form action="/index/commentBegin" method="post" >
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="message_id" value="{{$data['message_id']}}">
                            <button type="submit">详细信息</button>
                        </form>
                    </td>
                @endif
            </tr>
            <tr>
                <td colspan="5">
                   <pre>{!!$data['message']!!}</pre>
                </td>

            </tr>
        </table>
        <br>


    @endforeach


@endsection