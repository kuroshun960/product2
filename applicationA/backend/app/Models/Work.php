<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Work extends Model
{
    
    //この作品を所有するアーティスト
    
    protected $fillable = ['name','title','description',];
    
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
    
    public function work_artist_userid()
    {
        
        $artists = $this->artist()->get();
        foreach ($artists as $artist){}
        
        return $artist->user_id;
        
    }
    
    public function work_artist_id()
    {
        
        $artists = $this->artist()->get();
        foreach ($artists as $artist){}
        
        return $artist->id;
        
    }
    
}
