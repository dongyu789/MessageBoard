
@extends('public.base')
@section('title','语音留言转换')
@section('title_2','语音留言转换')
@section('mybody')



    <form action="/index/receiveVideoOver" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        传入语音文件：(wav,pcm : 16000 ; amr : 8000)
        <input type="file" name="video">
        <br>
        <br>
        选择语言类型：

        <select name="langType">
            <option value="1">中文普通话</option>
            <option value="2">四川话</option>
            <option value="3">粤语</option>
            <option value="4">英语</option>
        </select>
        <br>
        <br>
        <button type="submit">上传</button>

    </form>
    <br>
    <br>




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