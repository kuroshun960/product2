@extends('layouts.app')

@section('content')
<div class="container">


    <div class="text-center">
        <h1>アーティスト設定</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            
            <div>
            {!! Form::model($artistEdit, ['route' => ['artist.update', $artistEdit->id], 'enctype' => 'multipart/form-data','method' => 'put']) !!}
            
                    <div class="form-group">
            
                    {!! Form::label('name', 'アーティスト名:') !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                    <br>
                    {!! Form::label('description', '説明:') !!}
                    {!! Form::text('description', old('description'), ['class' => 'form-control']) !!}
                    <br>
                    {!! Form::label('style', 'スタイル:') !!}
                    {!! Form::text('style', old('style'), ['class' => 'form-control']) !!}
                    <br>
                    {!! Form::label('officialHp', '公式サイト:') !!}
                    {!! Form::text('officialHp', old('officialHp'), ['class' => 'form-control']) !!}
                    <br>
                    {!! Form::label('twitter', 'Twitter:') !!}
                    {!! Form::text('twitter', old('twitter'), ['class' => 'form-control']) !!}
                    <br>
                    {!! Form::label('insta', 'Instagram:') !!}
                    {!! Form::text('insta', old('insta'), ['class' => 'form-control']) !!}
                    <br>
                    {!! Form::label('file', '画像ファイル:') !!}
                    {!! Form::file('file', ['class' => 'form-control']) !!}
                    <br>
                        
                    {!! Form::submit('更新する', ['class' => 'btn btn-primary btn-block']) !!}
                    
                    </div>
            {!! Form::close() !!}
            </div>
            
            <div>
            
            @if(Auth::id() === $artistEdit->user_id)
            
            {!! Form::model($artistEdit, ['route' => ['artist.destroy', $artistEdit->id], 'method' => 'delete']) !!}
            <div class="form-group">
                {!! Form::submit('アーティストを削除', ['class' => 'btn btn-danger','onclick' => 'delete_alert(event);return false;']) !!}
            </div>
            {!! Form::close() !!} 
            
            @endif
        
            </div>
        
        </div>
    </div>


    
    
</div>




@endsection