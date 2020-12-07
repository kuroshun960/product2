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

{!! Form::open(['route' => 'artist.post', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        @csrf
        
        
        {!! Form::text('name', old(''), ['class' => 'form-control','placeholder' => 'アーティスト名']) !!}
        <br>

        {!! Form::text('description', old(''), ['class' => 'form-control','placeholder' => '説明']) !!}
        <br>

        {!! Form::text('style', old(''), ['class' => 'form-control','placeholder' => 'スタイル']) !!}
        <br>

        {!! Form::text('officialHp', old(''), ['class' => 'form-control','placeholder' => '公式サイト']) !!}
        <br>

        {!! Form::text('twitter', old(''), ['class' => 'form-control','placeholder' => 'Twitter']) !!}
        <br>

        {!! Form::text('insta', old(''), ['class' => 'form-control','placeholder' => 'Instagram']) !!}
        <br>
        {!! Form::label('file', '画像ファイル:') !!}
        {!! Form::file('file', ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit('アーティストを登録', ['class' => 'btn btn-primary btn-block']) !!}
        
    </div>
{!! Form::close() !!}




</div>
@endsection