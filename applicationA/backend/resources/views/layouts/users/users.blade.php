@if (count($users) > 0)
    <ul class="usersList list-unstyled d-flex flex-wrap">
        @foreach ($users as $user)
            <li class="media ml-4">
                {{-- ユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                <img class="mr-2 userIconimage" src="{{ $user->path }}" alt="">
                <div class="media-body">
                    <div>
                        {{-- ユーザ詳細ページへのリンク --}}
                        <p>{!! link_to_route('users.show', $user->name, ['user' => $user->id]) !!}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endif