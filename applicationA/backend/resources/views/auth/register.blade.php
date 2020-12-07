@extends('layouts.app')

@section('content')
<div class="container">

    <style>
        h1 {
            font-size: 40px;
        }
    </style>

    <div class="text-center">
        <h1>新規登録</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'signup.post']) !!}
                <div class="form-group">
                    
                    {!! Form::text('name', old('name'), ['class' => 'form-control','placeholder' => '名前']) !!}
                </div>

                <div class="form-group">
                    
                    {!! Form::email('email', old('email'), ['class' => 'form-control','placeholder' => 'メールアドレス']) !!}
                </div>

                <div class="form-group">
                    
                    {!! Form::password('password', ['class' => 'form-control','placeholder' => 'パスワード']) !!}
                </div>

                <div class="form-group">
                    
                    {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder' => 'パスワード（確認）']) !!}
                </div>

                {!! Form::submit('登録', ['class' => 'loginBtn']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    
    
</div>
@endsection