<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{

    use SoftDeletes;

    //将Message反向关联
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    //将Message和Comment正向关联
    public function comment()
    {
        return $this->hasMany(Comment::class, 'message_id', 'id');
    }

    //设置访问器，对message中的敏感字段进行覆盖替换
    public function getMessageAttribute($value)
    {
        $sensitiveWords = ['敏感字段', '九月加急', '敏感信息'];
        return str_replace($sensitiveWords, '****', $value);
    }

}
