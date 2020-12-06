@extends('layouts.app')

@section('content')
<div class="container">

{{-- {!! Form::open(['route' => 'tag.post', 'enctype' => 'multipart/form-data']) !!}  --}}

    <div class="arrow_r_box">
        <a class="arrow_r" href="{{ '/artist/'.$artistId->id }}"></a>
    </div>
    <div class="tagaddList">
    @foreach ($artistTags as $artistTag)
        <div class="tagaddList__inner">
            <div class="d-flex align-items-center tagaddList__items">
                <div class="tagaddList_tagname"><p><span>#</span>{{ $artistTag->name }}</p></div>
                <div class="">
                @if(Auth::id() === $artistTag->tags_artist_userid())
                {!! Form::model($artistTag, ['route' => ['tag.destroy', $artistTag->id], 'method' => 'delete']) !!}
                    {!! Form::submit('タグを削除', ['class' => 'tagDeleteBtn','onclick' => 'delete_alert(event);return false;']) !!}
                {!! Form::close() !!} 
                @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>

{{--{!! Form::model($artistId, ['route' => ['tag.post', $artistId->id], 'enctype' => 'multipart/form-data']) !!}--}}
{!! Form::open([route('tag.post', ['id' => $artistId->id])]) !!}
    <div class="form-group">
        @csrf
        
        {!! Form::text('name', old('名前'), ['class' => 'form-control','placeholder' => 'タグ名']) !!}
        <br>

        {!! Form::submit('登録', ['class' => 'btn btn-primary btn-block']) !!}
        
    </div>
{!! Form::close() !!}




</div>
@endsection