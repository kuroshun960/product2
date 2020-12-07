
    
    <div class="userdetails_container_inner">
        <div class="d-flex justify-content-around alignItemsCenter">
            
            <div>
                <h1><a class="authname" href="/users/{{Auth::user()->id}}"><img class="userIconimage" src="{{ Auth::user()->path }}" alt="">
                {{ Auth::user()->name }}</a><span class="userTimeline">のタイムライン</span></h1>
            </div>
            
        </div>
    </div>
    
    
    <div class="artistList">
        <div class="artistList__row d-flex flex-wrap">
            
            @foreach ($follows as $follow)

                @if(Auth::user()->id === $follow->user_id)
                <div class="artistList__row__items">
                    <a class="wappen" href="{{URL::to('artist/'.$follow->id)}}">
                        <div class="artistPanel">
                            <img src="{{ $follow->path }}" width="100%">
                        </div>
                    </a>
                    <p>{!! link_to_route('artist.show', $follow->name, ['id' => $follow->id]) !!}</p>
                </div>
                
                @else
                
                <div class="artistList__row__items">
                    <a href="{{URL::to('artist/'.$follow->id)}}">
                        <div class="artistPanel">
                            <img src="{{ $follow->path }}" width="100%">
                        </div>
                    </a>
                    <p>{!! link_to_route('artist.show', $follow->name, ['id' => $follow->id]) !!}</p>
                </div>
                
                @endif
        
        

            @endforeach
            
                    
            <div class="artistList__row__items">
                {{--<a href="#"><div class="artistPanel__add"><p>+</p></div></a>--}}
                {!! link_to_route('artist.input', '', [], ['class' => 'artistPanel__add']) !!}
            </div>



        </div>
    </div>
    

