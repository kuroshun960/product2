<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//S3用に追記//
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Artist;
use App\Models\User;

class ArtistsController extends Controller
{
    
/*--------------------------------------------------------------------------
    アーティスト追加ページ
--------------------------------------------------------------------------*/
    
    public function input()
    {
        return view('artists.artist_input');
    }
    
/*--------------------------------------------------------------------------
    アーティスト画像をS3にアップロードする処理
--------------------------------------------------------------------------*/

public function upload(Request $request)
    {        
        
        
        //名前と説明文のバリデーション
        
        $request->validate([
            'name' => 'required|max:20',
            'description' => 'required|max:255',
        ]);
        
        
        // 画像のアップ形式のバリデーション
        $this->validate($request, [
            'file' => [
                // 必須
                'required',
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
            ]
        ]);
        

        if ($request->file('file')->isValid([])) {
            
            //バリデーションを正常に通過した時の処理
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納する
            $upload_info = Storage::disk('s3')->putFile('/test', $request->file('file'), 'public');
            
            //S3へのファイルアップロード処理の時の情報が格納された変数を用いてアップロードされた画像へのリンクURLを変数に格納する
            $path = Storage::disk('s3')->url($upload_info);
            
            //現在ログイン中のユーザIDを変数$user_idに格納する
            $user_id = Auth::id();
            
            //モデルクラスのインスタンスを作成し、変数に格納
            $new_artist_data = new Artist();
            
            //このインスタンスを、”ログインユーザーが作成したインスタンス”として結びつける。
            $new_artist_data->user_id = $user_id;
            
            /*
            プロパティ(静的メソッド)に
            1.変数$pathに格納されている内容、
            2.$requestのnameの値
            3.$requestのdescriptionの値　を格納する
            */
            $new_artist_data->path = $path;
            $new_artist_data->name = $request->name;
            $new_artist_data->description = $request->description;
            $new_artist_data->style = $request->style;
            $new_artist_data->officialHp = $request->officialHp;
            $new_artist_data->twitter = $request->twitter;
            $new_artist_data->insta = $request->insta;
            
            //インスタンスの内容をDBのテーブルに保存する
            $new_artist_data->save();
            

            /* 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
            $request->user()->artist()->create([
            'name' => $request->name,
            'description' => $request->description,
            'path' => $path->path,
            ]);
            */

            return redirect('/');
            
        }else{
            //バリデーションではじかれた時の処理
            return redirect('/upload/image');
        }
        
        
    }
    
    
    
/*--------------------------------------------------------------------------
    タイムライン
--------------------------------------------------------------------------*/
    
    
    public function output()
    {
        
/*--------------------------------------------------------------------------
        //現在ログイン中のユーザIDを変数$user_idに格納する
        $user_id = Auth::id();
        
        //artistテーブルからuser_idカラムが変数$user_idと一致するレコード情報を取得し変数$artistsに格納する
        //artistテーブルからuser_idカラムが変数$user_idと一致するレコード情報を取得し変数$artistsに格納する
        
        $artists = Artist::whereUser_id($user_id)->get();
        return view('welcome', [
            'artists' => $artists
            
            ]);
--------------------------------------------------------------------------*/
            
        $data = [];
        if (\Auth::check()) {
            // 認証済みユーザ（閲覧者）を取得
            $user = \Auth::user();
            // ユーザとフォロー中ユーザの投稿の一覧を作成日時の降順で取得
            $followingArtist = $user->followingArtist()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'follows' => $followingArtist,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
            
    }
    
    
/*--------------------------------------------------------------------------
    アーティスト詳細情報を表示するアクション
--------------------------------------------------------------------------*/
    
    public function show($id)
    {
        
        // idの値でアーティストを検索して取得
        $artist = Artist::findOrFail($id);

        $artistTags = $artist->tags()->take(8)->get();
        
        $artistWorks = $artist->works()->get();
        
        
        
        // アーティスト詳細ビューでそれを表示
        return view('artists.artist_show', [
            'artist' => $artist,
            'artistTags' => $artistTags,
            'artistWorks' => $artistWorks,
        ]);
        
    }
        
        
/*--------------------------------------------------------------------------
    アーティスト情報 更新画面
--------------------------------------------------------------------------*/
    
    public function edit($id)
    {

        $artistEdit = Artist::findOrFail($id);
        
        return view('artists.artists_edit', [
            'artistEdit' => $artistEdit,
        ]);
        
        
    }
    

/*--------------------------------------------------------------------------
    アーティスト情報 更新処理
--------------------------------------------------------------------------*/
    
    public function update(Request $request, $id)
    {
        // 画像のアップ形式のバリデーション
        $this->validate($request, [
            'file' => [
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,png',
            ]
        ]);
        
        
        // idの値でメッセージを検索して取得
        $update_artist_data = Artist::findOrFail($id);


    if (\Auth::id() === $update_artist_data->user_id) {


        if ($request->file('file')) {
            
            //バリデーションを正常に通過した時の処理
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納する
            $upload_info = Storage::disk('s3')->putFile('/test', $request->file('file'), 'public');
            
            //S3へのファイルアップロード処理の時の情報が格納された変数を用いてアップロードされた画像へのリンクURLを変数に格納する
            $path = Storage::disk('s3')->url($upload_info);

            // メッセージを更新
            $update_artist_data->path = $path;
            
        }
        
            $update_artist_data->name = $request->name;
            $update_artist_data->description = $request->description;
            $update_artist_data->style = $request->style;
            $update_artist_data->officialHp = $request->officialHp;
            $update_artist_data->twitter = $request->twitter;
            $update_artist_data->insta = $request->insta;
            
            //インスタンスの内容をDBのテーブルに保存する
            $update_artist_data->save();
        

            return redirect('/artist/'.$id);
        }
    else{    
        return redirect('/');
    }
            
    }
    
    
/*--------------------------------------------------------------------------
    アーティスト削除
--------------------------------------------------------------------------*/
    
    public function destroy($id)
    {

        $artistEdit = Artist::findOrFail($id);
        
        
        
            if (\Auth::id() === $artistEdit->user_id) {
                
                //子供リレーション（タグ）を削除
                $artistEdit->tags()->each(function ($tag) {
                    $tag->delete();
                });
                
                //子供リレーション（作品）を削除
                $artistEdit->works()->each(function ($work) {
                    $work->delete();
                });
                
                //アーティスト（親）を削除
                $artistEdit->delete();
        
                return redirect('/');
            }
            
            else{    
                return redirect('/');
            }
            
            
    
    }










}
