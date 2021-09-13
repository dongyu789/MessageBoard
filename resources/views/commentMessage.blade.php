
@extends('public.base')
@section('title', '评论')

@section('title_2', '评论')
@section('username', $username)
@section('mybody')
{{--    先显示原留言，下面显示所有评论--}}
<h2>原留言</h2>
    <table border="1">
        <tr>
            <td>用户 ： {{$message->user_id}}</td>
            <td>发帖时间 ： {{$message->created_at}}</td>
            <td>修改时间 ： {{$message->updated_at}}</td>
        </tr>
        <tr>
            <td colspan="5"><pre>{{$message->message}}</pre></td>
        </tr>
    </table>

{{--    显示评论--}}
    <br>
    <br>
    <br>

<h2>以下显示评论</h2>
    @foreach($comments as $comment)
        <table border="1">
            <tr>
                <td>用户 ： {{$comment->user_id}}</td>
                <td>发帖时间 ： {{$comment->created_at}}</td>
                <td>修改时间 ： {{$comment->updated_at}}</td>
            </tr>
            <tr>
                <td colspan="5"><pre>{{$comment->comment}}</pre></td>
            </tr>
        </table>
        <br>
    @endforeach
{{$comments->links()}}

    <br>

    <form action="/index/commentMessageOver" method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="message_id" value="{{$message->id}}">
        <br>
        <br>
        写评论 ： <input style="width: 200px;height:60px;" type="text" name="comment" >
        <br>
        <br>
        <br>
        <br>

        <button type="submit">提交</button>
    </form>


@endsection
