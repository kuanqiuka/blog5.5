<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //1.关联数据库的表
    public $table = 'user';
    //2.主键
    public $primaryKey = 'user_id';

    //3.是否允许批量操作的字段（即增删改查）
    //public $fillable = ['user_name','user_pass','email','phone'];
    public $guarded = [];//不允许的字段

    //4.是否维护created_at,updated_at
    public $timestamps = false;
}
