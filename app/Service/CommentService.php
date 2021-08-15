<?php


namespace App\Service;



use App\Repository\CommentRepository;

class CommentService
{
    /**
     * 提交评论
     */
    public function commitComment($comment, $username, $messageId)
    {
        //存入数据库
        app(CommentRepository::class)->save($comment, $username, $messageId);
    }

}