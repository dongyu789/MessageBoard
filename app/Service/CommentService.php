<?php


namespace App\Service;

use App\Models\Comment;
use App\Models\Message;
use App\Models\User;
use App\Repository\MessageRepository;

class CommentService
{
    /**
     * 提交评论
     */
    public function commitComment($user_id, $message)
    {
        app(MessageRepository::class)->save($user_id, $message);
    }
}