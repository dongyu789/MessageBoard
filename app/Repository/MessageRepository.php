<?php


namespace App\Repository;
use App\Models\Message;

class MessageRepository
{
    public function save($user_id, $message)
    {
        $newMessage = new Message();
        $newMessage->user_id = $user_id;
        $newMessage->message = $message;
        $newMessage->save();
    }
}