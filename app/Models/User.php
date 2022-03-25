<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\MustVerifyEmail as MustverifyEmailTrait;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,MustverifyEmailTrait;
    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance){
        //如果要通知的是当前用户，就不必通知了
        if($this->id == Auth::id()){
            return ;
        }

        //只有数据库类型通知才需提醒，直接发送 Email 或者其他的Pass
        if(method_exists($instance,'toDatabase')){
            $this->increment('notification_count');
        }
        $this->laravelNotify($instance);
    }
    /**
     * The attributes that are mass assignable.
     * $fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则更新时会被忽略
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'acatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function topics(){
        return $this->hasMany(Topic::class);
    }
    public function isAuthorOf($model){
        return $this->id == $model->user_id;
    }
    public function replies(){
        return $this->hasMany(Reply::class);
    }
}
