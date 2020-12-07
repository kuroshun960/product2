<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//S3用
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

//ここでは、Userモデルのモデル操作をするので、あらかじめ名前空間をUserに設定しておく
use App\User;

class UsersController extends Controller
{
    
    public function index()
    {
        // ユーザ一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);

        // ユーザ一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    
    public function show($id)
    {
        
        // idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        $user->loadRelationshipCounts();
        
        $userArtists = $user->artist()->get();

        // ユーザ詳細ビューでそれを表示
        return view('users.usershow', [
            'user' => $user,
            'userArtists' => $userArtists,
        ]);
    }
    
    
/*----------------------------------------------------
    ユーザー設定の編集ページ
----------------------------------------------------*/
    
    public function edit($id)
    {
        
        $userSetting = User::findOrFail($id);
        
        return view('users.user_setting', [
            'userSetting' => $userSetting,
        ]);

    }

/*----------------------------------------------------
    ユーザー設定の更新処理
----------------------------------------------------*/

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
            $userSetting = User::findOrFail($id);
        

        if ($request->file('file')) {
            
            //バリデーションを正常に通過した時の処理
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納する
            $upload_info = Storage::disk('s3')->putFile('/test', $request->file('file'), 'public');
            
            //S3へのファイルアップロード処理の時の情報が格納された変数を用いてアップロードされた画像へのリンクURLを変数に格納する
            $path = Storage::disk('s3')->url($upload_info);
            
            $userSetting->path = $path;
            }
            

            // メッセージを更新
            $userSetting->name = $request->name;
            $userSetting->email = $request->email;
            
            $userSetting->save();
            

            return redirect('/');
    
            
    }
    
    
    
    
    
    
    
    public function followings($id)
    {
        // idの値でユーザを検索して取得
        $usernumber = User::findOrFail($id);

        // 関係するモデルの件数をロード(数をフォロー数を数字で表示)
        $usernumber->loadRelationshipCounts();

        // ユーザのフォロー一覧を取得
        $followingsUsers = $usernumber->followings()->paginate(10);

        // フォロー一覧ビューでそれらを表示
        return view('users.user_followings', [
            'usernumber' => $usernumber,
            'followingsUsers' => $followingsUsers,
        ]);
        
        
    }
    
    public function followers($id)
    {
        // idの値でユーザを検索して取得
        $usernumber = User::findOrFail($id);

        // 関係するモデルの件数をロード
        $usernumber->loadRelationshipCounts();

        // ユーザのフォロワー一覧を取得
        $followersUsers = $usernumber->followers()->paginate(10);

        // フォロワー一覧ビューでそれらを表示
        return view('users.user_followers', [
            'usernumber' => $usernumber,
            'followersUsers' => $followersUsers,
        ]);
    }
    
    
    
  
    
}
