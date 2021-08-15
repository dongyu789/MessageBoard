<?php


namespace App\Repository;


use App\Models\Comment;

class CommentRepository
{

    public function __construct()
    {
        $this->model = new Comment();
    }

    public function save($comment, $username, $messageId)
    {
        $new_comment = $this->model;
        $new_comment->comment = $comment;
        $new_comment->user_id = $username;
        $new_comment->message_id = $messageId;
        $new_comment->save();
    }

}