@extends('layouts.app')

@section('content')
<div class="container">

    {{-- ユーザ一覧 --}}
    <div class="text-center">
        <h1>USERS</h1>
    </div>
    @include('users.users')
    
    
</div>
@endsection