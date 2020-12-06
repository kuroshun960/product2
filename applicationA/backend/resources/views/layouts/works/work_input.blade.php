@extends('layouts.app')

@section('content')
<div class="container">

<!-- 
<form action="/upload/artist" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="photo">画像ファイル:</label>
    <input type="file" class="form-control" name="file">
    <br>
    <input type="submit">
</form>
-->


{{--{!! Form::model($artistId, ['route' => ['work.post', $artistId->id], 'enctype' => 'multipart/form-data']) !!}--}}
{!! Form::open(['route'=>['work.post','id' => $artistId->id],'enctype' => 'multipart/form-data']) !!}


    <div class="form-group">
        @csrf
        
        {!! Form::label('title', 'タイトル:') !!}
        {!! Form::text('title', old('タイトル'), ['class' => 'form-control','placeholder' => 'タイトル']) !!}
        <br>
        {!! Form::label('description', '説明:') !!}
        {!! Form::text('description', old('説明'), ['class' => 'form-control','placeholder' => '説明']) !!}
        <br>
        {!! Form::label('file', '画像ファイル:') !!}
        {!! Form::file('file', ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit('作品を登録', ['class' => 'btn btn-primary btn-block']) !!}
        
    </div>
{!! Form::close() !!}




</div>
@endsection