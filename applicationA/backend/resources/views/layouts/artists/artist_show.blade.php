@extends('layouts.app')

@section('content')

<style type="text/css">

.backgroundBlur {
  background:url({{ $artist->path }}) no-repeat center center;
  background-size: contain;
  filter:brightness(100%);
  overflow: hidden;
  position: relative;
  z-index: 0;
}

.backgroundBlur::before {
  content: "";
  display: block;
  position: absolute;
  background: inherit;
  filter: blur(100px);
  top: -500px;
  right: -500px;
  bottom: -500px;
  left: -500px;
  z-index: -1;
  
}
</style>

<div class="backgroundBlur">
<div class="container" style="background-image">


    <div class="artistdetails_container_inner">
        <div class="d-flex tagAddbtn__Frex">
            <div class="workshow_title d-flex">
            
                <div class="arrow_r_box">
                    <a class="arrow_r" href="{{ '/users/'.$artist->artist_user_id() }}"></a>
                </div>
                <h1>
                <img class="mr-2 rounded mywv_artistIcon" src="{{ $artist->path }}" width="100%">
                {{ $artist->name }}
                </h1>
            
            
            </div>
            @foreach ($artistTags as $artistTag)
            <span class="artistTags">　{{ $artistTag->name }}　/</span>
            @endforeach
            
            
            
            <div class="tagAddbtn"><p>{!! link_to_route('tag.input', '+', ['id' => $artist->id], ['class' => '']) !!}</p></div>
            
            @if (Auth::id() === $artist->user_id )
            <div class="artistEditBtn">{!! link_to_route('artist.edit', 'アーティストを編集', ['id' => $artist->id], ['class' => '']) !!}</div>
            @endif
            
        </div>
    </div>
    
    
    <div class="artistList">
        <div class="artistList__row d-flex flex-wrap">
            
            @foreach ($artistWorks as $artistWork)

            <div class="artistList__row__items">
                <a href="{{URL::to('/artist/work/'.$artistWork->id)}}">
                    <div class="artistPanel">
                        <img src="{{ $artistWork->path }}" width="100%">
                    </div>
                </a>
                <p>{!! link_to_route('work.show', $artistWork->title, ['id' => $artistWork->id]) !!}</p>

            </div>

            @endforeach


            {{---自分のアーティストリストにしか作品は追加できない---}}
            @if (Auth::id() === $artist->user_id )
       
            <div class="artistList__row__items">
                {{--<a href="#"><div class="artistPanel__add"><p>+</p></div></a>--}}
                <div class="">
                {!! link_to_route('work.input', '', ['id' => $artist->id], ['class' => 'artistPanel__add']) !!}
                </div>
            </div>

            @endif


        </div>
    </div>
    
    <div class="descriptionArea">
        <div class="descriptionArea__inner">
            
        <div class="artistStyle">
        <p class="">STYLE　|　{{ $artist->style }}</p>
        </div>
        
        <div class="artistDescription">
        <p>{{ $artist->description }}</p>
        </div>
        
        <div class="snsUrl">
            
            @if( $artist->officialHp ==! null)
            <p><a href="{{ $artist->officialHp }}"><span class="fa fa-desktop mr-2"></span>公式サイト</a></p>
            @endif
            @if( $artist->twitter ==! null)
            <p><a href="{{ $artist->twitter }}"><span class="fab fa-twitter mr-2"></span>twitter</a></p>
            @endif
            @if( $artist->insta ==! null)
            <p><a href="{{ $artist->insta }}"><span class="fab fa-instagram mr-2"></span>instagram</a></p>
            @endif
        </div>
        
        </div>
    </div>

</div>
</div>
@endsection