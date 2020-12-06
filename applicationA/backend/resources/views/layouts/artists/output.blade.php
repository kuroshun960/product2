@extends('layouts.app')

@section('content')
<div class="container">


    <a href="/upload">画像のアップロードに戻る</a>
    <br>
    @foreach ($user_images as $user_image)
        <img src="{{ $user_image['path'] }}" width="200px">
        <br>
    @endforeach
    
    
    
</div>
@endsection