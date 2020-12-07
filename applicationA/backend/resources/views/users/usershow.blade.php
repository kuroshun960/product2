@extends('layouts.app')

@section('content')
<div class="container">
 
 
   
    <div class="userdetails_container_inner">
        <div class="d-flex justify-content-around alignItemsCenter">
            <div class="followcount"><a href="{{ route('users.followings', ['id' => $user->id]) }}">follow :　{{ $user->followings_count }}</a></div>
            
            <div class="d-flex justify-content-around alignItemsCenter">
                <h1>
                <img class="mr-2 userIconimage" src="{{ $user->path }}" alt="">
                {{ $user->name }}
                </h1>
                    @include('user_follow.follow_button')
            </div>
            
            <div class="followcount"><a href="{{ route('users.followers', ['id' => $user->id]) }}">follower :　{{ $user->followers_count }}</a></div>
            
        </div>
        
        <div class="phone_followcount" style="">
        <div><a href="{{ route('users.followings', ['id' => $user->id]) }}">follow :　{{ $user->followings_count }}</a></div>
        <div><a href="{{ route('users.followers', ['id' => $user->id]) }}">follower :　{{ $user->followers_count }}</a></div>
        </div>
        
    </div>
    
    
    <div class="artistList">
        <div class="artistList__row d-flex flex-wrap">
            
            @foreach ($userArtists as $userArtist)

            <div class="artistList__row__items">
                <a href="{{URL::to('artist/'.$userArtist->id)}}">
                    <div class="artistPanel">
                        <img src="{{ $userArtist->path }}" width="100%">
                    </div>
                </a>
                <p>{!! link_to_route('artist.show', $userArtist->name, ['id' => $userArtist->id]) !!}</p>

            </div>

            @endforeach
            
            {{-- この詳細ページのユーザーのアカウントが自分の物だったらアーティスト追加ボタンを表示する --}}
            
            @if (Auth::id() === $user->id )
            <div class="artistList__row__items">
                {{--<a href="#"><div class="artistPanel__add"><p>+</p></div></a>--}}
                {!! link_to_route('artist.input', '', [], ['class' => 'artistPanel__add']) !!}
            </div>
            @endif


        </div>
    </div>
    





</div>
@endsection