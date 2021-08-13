<?php


namespace App\Repository;
use App\Models\Message;

class MessageRepository
{
    /**
     * @var mixed
     */
    private $message_id;

    public function save($user_id, $message)
    {
        //存入数据库
        $newMessage = new Message();
        $newMessage->user_id = $user_id;
        $newMessage->message = $message;
        $newMessage->save();
        $this->message_id = $newMessage->id;
    }
    
    public function getMessage_id()
    {
        return $this->message_id;
    }
}