<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    //このタグを所有するアーティスト
    
    protected $fillable = ['name'];
    
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
    
    
    public function tags_artist_userid()
    {
        
        $artists = $this->artist()->get();
        foreach ($artists as $artist){}
        
        return $artist->user_id;
        
    }
    
    public function tags_artist_id()
    {
        
        $artists = $this->artist()->get();
        foreach ($artists as $artist){}
        
        return $artist->id;
        
    }
    
}
