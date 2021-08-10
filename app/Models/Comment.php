<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //定义访问器，过滤敏感字段
    public function getCommentAttribute($value)
    {
        $sensitiveWords = ['敏感字段', '九月加急'];
        return str_replace($sensitiveWords, '****', $value);
    }
}
