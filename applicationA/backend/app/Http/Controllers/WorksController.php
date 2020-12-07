<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//S3用に追記//
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Artist;
use App\Work;

class WorksController extends Controller
{

/*--------------------------------------------------------------------------
    作品追加ページ
--------------------------------------------------------------------------*/
    
    public function input($id)
    {
        
        //受け取ったid情報を変数に格納して、タグ生成ページへ又貸し。
        $artistId = Artist::findOrFail($id);
        
        $artistTags = Artist::findOrFail($id)->tags()->get();
        
        
        return view('works.work_input',[
            'artistId' => $artistId,
            'artistTags' => $artistTags,
            ]);
    }


/*--------------------------------------------------------------------------
    作品画像をS3にアップロードする処理
--------------------------------------------------------------------------*/

public function upload(Request $request, $id)
    {        
        
        
        //名前と説明文のバリデーション
        
        $request->validate([
            'title' => 'required|max:20',
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
            $upload_info = Storage::disk('s3')->putFile('/works', $request->file('file'), 'public');
            
            //S3へのファイルアップロード処理の時の情報が格納された変数を用いてアップロードされた画像へのリンクURLを変数に格納する
            $path = Storage::disk('s3')->url($upload_info);
            
            //登録する作品のアーティストのIDを変数$user_idに格納する
            $artist_id = $id;

            //モデルクラスのインスタンスを作成し、変数に格納
            $new_work_data = new Work();
            
            //このインスタンスを、”ログインユーザーが作成したインスタンス”として結びつける。
            $new_work_data->artist_id = $artist_id;
            
            /*
            プロパティ(静的メソッド)に
            1.変数$pathに格納されている内容、
            2.$requestのnameの値
            3.$requestのdescriptionの値　を格納する
            */
            $new_work_data->path = $path;
            $new_work_data->title = $request->title;
            $new_work_data->description = $request->description;
            
            //インスタンスの内容をDBのテーブルに保存する
            $new_work_data->save();
            

            /* 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
            $request->user()->artist()->create([
            'name' => $request->name,
            'description' => $request->description,
            'path' => $path->path,
            ]);
            */

            return redirect('/artist/'.$id);
            
        }else{
            //バリデーションではじかれた時の処理
            return redirect('/');
        }
        
        
    }
    

/*--------------------------------------------------------------------------
    作品詳細情報を表示するアクション
--------------------------------------------------------------------------*/
    
    public function show($id)
    {
        
        // idの値でアーティストを検索して取得
        $workId = Work::findOrFail($id);
        
        $workArtistId = $workId->artist()->get();
        


        // アーティスト詳細ビューでそれを表示
        return view('works.work_show', [
            'workId' => $workId,
            'workArtistId' => $workArtistId,
        ]);
        
    }


/*--------------------------------------------------------------------------
    作品情報 更新画面
--------------------------------------------------------------------------*/
    
    public function edit($id)
    {

        $workEdit = Work::findOrFail($id);
        
        return view('works.work_edit', [
            'workEdit' => $workEdit,
        ]);
        
        
    }


/*--------------------------------------------------------------------------
    作品 更新処理
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
        $update_work_data = Work::findOrFail($id);




        if ($request->file('file')) {
            
            //バリデーションを正常に通過した時の処理
            //S3へのファイルアップロード処理の時の情報を変数$upload_infoに格納する
            $upload_info = Storage::disk('s3')->putFile('/test', $request->file('file'), 'public');
            
            //S3へのファイルアップロード処理の時の情報が格納された変数を用いてアップロードされた画像へのリンクURLを変数に格納する
            $path = Storage::disk('s3')->url($upload_info);

            // メッセージを更新
            $update_work_data->path = $path;
            
        }
        
            $update_work_data->title = $request->title;
            $update_work_data->description = $request->description;
            
            //インスタンスの内容をDBのテーブルに保存する
            $update_work_data->save();
        

            return redirect('/artist/work/'.$id);
        

            
    }
    




/*--------------------------------------------------------------------------
    作品削除処理
--------------------------------------------------------------------------*/
    
    public function destroy($id)
    {
        
    $workEdit = Work::findOrFail($id);

    
        //アーティスト（親）を削除
        $workEdit->delete();

        return redirect('/');
        

   
    }
    















}
