<?php


namespace App\Service;

use App\Models\Comment;
use App\Models\Message;
use App\Models\User;
use App\Repository\ESRepository;
use App\Repository\MessageRepository;

class CommentService
{
    /**
     * 提交评论
     */
    public function commitComment($user_id, $message)
    {
        //存入数据库
        $messageRepository = new MessageRepository();
        $messageRepository->save($user_id, $message);
        $messageId = $messageRepository->getMessage_id();

        $esRepository = new ESRepository();
        $esRepository->save($user_id, $message, $messageId);
    }
}