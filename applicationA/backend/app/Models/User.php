<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'name', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function artist()
    {
        return $this->hasMany(Artist::class);
    }
    
    public function loadRelationshipCounts()
    {
        $this->loadCount('artist','followings','followers',);
    }
    
    
/*--------------------------------------------------------------------------------------------------------
     このユーザがフォロー中のユーザ。（ Userモデルとの関係を定義）2.参照テーブル 3.自分のid 4.相手先のid
--------------------------------------------------------------------------------------------------------*/

    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

/*--------------------------------------------------------------------------------------------------
     このユーザをフォロー中のユーザ。（ Userモデルとの関係を定義）
--------------------------------------------------------------------------------------------------*/

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }
    
    
/*--------------------------------------------------------------------------------------------------
     フォロー中かどうかを判定した後、フォローする処理
--------------------------------------------------------------------------------------------------*/
    
    public function follow($Aiteno_Id)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($Aiteno_Id);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $Aiteno_Id;

        if ($exist || $its_me) {
            // すでにフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($Aiteno_Id);
            return true;
        }
    }
    
/*--------------------------------------------------------------------------------------------------
     フォロー中かどうかを判定した後、フォローをはずす処理
--------------------------------------------------------------------------------------------------*/
    
    public function unfollow($Aiteno_Id)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($Aiteno_Id);
        // 相手が自分自身かどうかの確認
        $its_me = $this->id == $Aiteno_Id;

        if ($exist && !$its_me) {
            // すでにフォローしていればフォローを外す
            $this->followings()->detach($Aiteno_Id);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }

/*--------------------------------------------------------------------------------------------------
     フォロー中かどうかを判定する処理
--------------------------------------------------------------------------------------------------*/
    
    public function is_following($Aiteno_Id)
    {
        // フォロー中ユーザの中に $Aiteno_Idのものが存在するか。
        return $this->followings()->where('follow_id', $Aiteno_Id)->exists();
    }
    
    
/*--------------------------------------------------------------------------------------------------
     フォロー中ユーザーのidと自分のidを配列に入れ、そのidの所有するidを取得する
--------------------------------------------------------------------------------------------------*/
    
    public function followingArtist()
    {
        // このユーザがフォロー中のユーザのid(usersテーブルのidカラム)を取得して配列にする
        $userIds = $this->followings()->pluck('users.id')->toArray();
        // このユーザのidもその配列に追加
        $userIds[] = $this->id;
        // それらのユーザが所有する投稿に絞り込む
        return Artist::whereIn('user_id', $userIds);
    }
    
    
    
    
    
    
}
