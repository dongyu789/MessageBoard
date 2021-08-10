<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    //protected $primaryKey = 'user_id';
    //将User正向关联Message

    use SoftDeletes;

    public function message()
    {
        return $this->hasMany(Message::class, 'user_id', 'user_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id', 'user_id');
    }
}
