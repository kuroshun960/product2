<header class="">
    
    <nav class="navbar navbar-expand-sm mywvNavbar">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand headerMywvLogo" href="/">MyWV</a>
        
        {{-- トグルボタン --}}
        <div class="d-flex">
            
        {{-- スマホのみ、ナビゲーションバーにユーザーアイコンを表示する --}}
        @if (Auth::check())
        <div class="phoneusericon"><img class="mr-2 userIconimage" src="{{ Auth::user()->path }}" alt=""></div>
        @endif
        {{----------------------}}
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>
        </div>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                
                {{--認証分岐--}}
                @if (Auth::check())
                    {{-- ドロップダウンメニュー --}}
                    <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle nav-item-Mywv" data-toggle="dropdown">
                        <div class="toggleinIcon">
                        <span class="navUsername">{{ Auth::user()->name }}</span>
                        <img class="mr-2 userIconimage" src="{{ Auth::user()->path }}" alt="">
                        </div>
                    </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            {{-- ユーザ詳細ページへのリンク --}}
                            <li class="dropdown-item nav-item-Mywv-drop">{!! link_to_route('users.show', Auth::user()->name, ['user' => Auth::id()]) !!}</li>
                            {{-- ユーザ一覧ページへのリンク --}}
                            <li class="dropdown-item nav-item-Mywv-drop">{!! link_to_route('users.index', 'Users', [], ['class' => '']) !!}</li>
                            {{-- ユーザ一設定 --}}
                            <li class="dropdown-item nav-item-Mywv-drop">{!! link_to_route('users.edit', 'Setting', ['user' => Auth::id()]) !!}</li>
                            <li class="dropdown-divider"></li>
                            {{-- ログアウトへのリンク --}}
                            <li class="dropdown-item nav-item-Mywv-drop">{!! link_to_route('logout.get', 'Logout') !!}</li>
                        </ul>
                    </li>
                @else
                    {{-- ユーザ登録ページへのリンク --}}
                    <li class="nav-item nav-item-Mywv">{!! link_to_route('signup.get','新規登録',[],['class'=>'nav-link']) !!}</li>
                    {{-- ログインページへのリンク --}}
                    <li class="nav-item nav-item-Mywv">{!! link_to_route('login', 'ログイン', [], ['class' => 'nav-link']) !!}</li>
                @endif
            </ul>
        </div>
        
    </nav>
</header>