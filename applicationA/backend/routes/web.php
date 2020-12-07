<?php

//S3用に追記//
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/', function () {
        return view('welcome');
    });


/*--------------------------------------------------------------------------
    ユーザ登録
--------------------------------------------------------------------------*/
    
        // ユーザ登録ページ表示
        Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
        // ユーザ登録ページから送られたリクエストの作成処理(create ≒ post ≒ store)
        Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
        
/*--------------------------------------------------------------------------
    認証
--------------------------------------------------------------------------*/
        
        // ログインページ表示
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        // ログイン処理
        Route::post('login', 'Auth\LoginController@login')->name('login.post');
        // ログアウトボタン
        Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');
        
/*-----------------------------------------------------------------------------------------
    ユーザー関連ページ(index:ユーザー一覧 show:ユーザー詳細のみ作成できる)に
    アクセスするには認証を必要とする
    ※将来的にユーザー削除機能もつける場合はdestroyを追加する
-----------------------------------------------------------------------------------------*/

    ///////////////*** 認証付きルート***////////////////////
    
        Route::group(['middleware' => ['auth']], function () {
            Route::resource('users', 'UsersController', ['only' => ['index', 'show','edit','update']]);
            
            
/*-----------------------------------------------------------------------------------------
    タグ追加機能
-----------------------------------------------------------------------------------------*/

    //タグをアップロードする処理のルーティング
    Route::post('/create/artist/{id}/tag/', 'TagsController@create')->name('tag.post');
    //タグをアップロードするページ
    Route::get('/create/artist/{id}/tag/', 'TagsController@input')->name('tag.input');
    //タグをアップロードするページ
    Route::get('/create/artist/{id}/tag/', 'TagsController@input')->name('tag.input');
    //タグを消す処理
    Route::delete('/create/artist/{id}/tag/', 'TagsController@destroy')->name('tag.destroy');
    
/*-----------------------------------------------------------------------------------------
    作品投稿機能
-----------------------------------------------------------------------------------------*/

    //作品をアップロードするページ
    Route::get('/upload/artist/{id}/work', 'WorksController@input')->name('work.input');
    //作品をアップロードする処理のルーティング
    Route::post('/upload/artist/{id}/work', 'WorksController@upload')->name('work.post');
    //作品の詳細ページを表示するページ
    Route::get('/artist/work/{id}', 'WorksController@show')->name('work.show');
    //作品の詳細ページを表示するページ
    Route::get('/artist/work/{id}/edit', 'WorksController@edit')->name('work.edit');
    //作品の詳細ページを表示するページ
    Route::put('/artist/work/{id}', 'WorksController@update')->name('work.update');
    //作品の詳細ページを表示するページ
    Route::delete('/artist/work/{id}', 'WorksController@destroy')->name('work.destroy');
 
    
/*-----------------------------------------------------------------------------------------
    フォロー機能
-----------------------------------------------------------------------------------------*/

    //フォローする処理を実行する処理
    Route::post('/users/{id}/follow', 'UserFollowController@store')->name('user.follow');
    //フォロー外す処理を実行する処理
    Route::delete('/users/{id}/unfollow', 'UserFollowController@destroy')->name('user.unfollow');
    //フォロー一覧
    Route::get('/users/{id}/followings', 'UsersController@followings')->name('users.followings');
    //フォロワー一覧
    Route::get('/users/{id}/followers', 'UsersController@followers')->name('users.followers');



/*-----------------------------------------------------------------------------------------
    アーティスト登録機能
-----------------------------------------------------------------------------------------*/

    //アーティストをアップロードするページ
    Route::get('/upload/artist', 'ArtistsController@input')->name('artist.input');
    //アーティストをアップロードする処理のルーティング
    Route::post('/upload/artist', 'ArtistsController@upload')->name('artist.post');
    //アーティストの詳細ページを表示するページ
    Route::get('/artist/{id}', 'ArtistsController@show')->name('artist.show');
    //アーティストの詳細ページを更新するページ
    Route::get('/artist/{id}/edit', 'ArtistsController@edit')->name('artist.edit');
    //アーティストの詳細ページの更新処理
    Route::put('/artist/{id}', 'ArtistsController@update')->name('artist.update');
    //アーティスト削除処理
    Route::delete('/artist/{id}', 'ArtistsController@destroy')->name('artist.destroy'); 
    
    }); //認証付きルートはここまで
        
    //アップロードしたアーティストをタイル表示するページ
    Route::get('/', 'ArtistsController@output')->name('artist.output');

    
    

        



