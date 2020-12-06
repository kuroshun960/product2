@extends('layouts.app')

@section('content')
<div class="container">

    <div class="text-center">
        <h1>ログイン</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'login.post']) !!}
                <div class="form-group">
                    {!! Form::email('email', old('email'), ['class' => 'form-control','placeholder' => 'メールアドレス']) !!}
                </div>

                <div class="form-group">
                    {!! Form::password('password', ['class' => 'form-control','placeholder' => 'パスワード']) !!}
                </div>

                {!! Form::submit('ログイン', ['class' => 'loginBtn']) !!}
            {!! Form::close() !!}

            {{-- ユーザ登録ページへのリンク --}}
            <p class="mt-4 notUser">まだ登録してない方は {!! link_to_route('signup.get', '今すぐ無料登録!',['class'=>'notUsertext']) !!}</p>
        </div>
    </div>
    
    
</div>
@endsection