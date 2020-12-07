<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    
    protected $fillable = ['name','description','style',];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //このアーティストが所有するタグ
    
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
    
    public function works()
    {
        return $this->hasMany(Work::class);
    }
    
    public function loadRelationshipCounts()
    {
        $this->loadCount('tags','works');
    }
    
    public function artist_user_id()
    {
        
        $users = $this->user()->get();
        foreach ($users as $user){}
        
        return $user->id;
        
    }
        

    
}
