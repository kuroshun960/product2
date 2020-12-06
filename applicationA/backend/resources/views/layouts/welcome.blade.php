@extends('layouts.app')

@section('content')


    @if (Auth::check())
    <div class="container">   
        
        @include('users.userdetails')
        
        
    </div>
    @else 
    <div class="beforeLogincontainer"> 
    
        <div class="userRegistArea">
            <div class="text-center">
                <h1>#アイディアを見つけよう！</h1>
                <div class="marginZeroauto">
                    {!! link_to_route('signup.get','登録する',[],['class'=>'userRegistBtn']) !!}</div>
            </div>
        </div>
    </div>
    @endif
    

@endsection