<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    //用户模型关联的表
    public $table = 'blog_user';

    //表的主键
    public $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *允许批量操作的字段,crud
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    //禁用时间戳
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
