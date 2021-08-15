<?php


namespace App\Repository;
use App\Models\Message;

class MessageRepository
{
    /**
     * @var mixed
     */
    private $message_id;
    public function __construct()
    {
        $this->model = new Message();
    }

    public function save($user_id, $message)
    {
        //存入数据库
        $newMessage = $this->model;
        $newMessage->user_id = $user_id;
        $newMessage->message = $message;
        $newMessage->save();
        $this->message_id = $newMessage->id;
    }
    
    public function getMessage_id()
    {
        return $this->message_id;
    }

    public function delete($messageId)
    {
        $this->model->where('id', $messageId)->delete();
    }

    public function update($messageId, $newMessage)
    {
        $message = $this->model->find($messageId);
        $message->message = $newMessage;
        $message->save();
    }
}