<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Artist;
use App\Models\Tag;

class TagsController extends Controller
{

/*--------------------------------------------------------------------------
    タグ追加ページ
--------------------------------------------------------------------------*/
    
    public function input($id)
    {
        
        //受け取ったid情報を変数に格納して、タグ生成ページへ又貸し。
        $artistId = Artist::findOrFail($id);
        
        $artistTags = Artist::findOrFail($id)->tags()->get();
        
        return view('tags.tag_input',[
            'artistId' => $artistId,
            'artistTags' => $artistTags,
            ]);
        
    }


/*--------------------------------------------------------------------------
    タグをアーティストに登録する処理
--------------------------------------------------------------------------*/

    public function create(Request $request, $id)
    {        
        
        $request->validate([
            'name' => 'required|max:20',
        ]);

        //modelフォームから送られてきたidで目的のアーティストを取得
        $artist = Artist::findOrFail($id);
        
        //※デバッグ用 アーティスト所有してるタグを全て取得
        $artistTag = $artist->tags()->get();
        
        //※デバッグ用 アーティスト所有してるタグを全て取得
        $artist->tags()->create([
            'name' => $request->name,
        ]);


        // 投稿後リダイレクト
        return redirect('/create/artist/'.$id.'/tag');
        
    }
    
/*--------------------------------------------------------------------------
    作品削除処理
--------------------------------------------------------------------------*/
    
    public function destroy($id)
    {
        
    $artistTag = Tag::findOrFail($id);
        
        //もし操作してるユーザーのidが、このタグのアーティストのuser_idとおなじだったら
        if (\Auth::id() === $artistTag->tags_artist_userid()) {
    
        //このタグのアーティストのartist_idを格納
        $artistPage = $artistTag->tags_artist_id();
        
    
        //アーティスト（親）を削除
        $artistTag->delete();

        //このタグのアーティストのartist_idをURL挿入して、アーティストページにリダイレクトさせる。
        return redirect('/create/artist/'.$artistPage.'/tag');
        
        }else{
            return redirect('/create/artist/'.$artistPage);
        }
        

   
    }
    








    
    

}
