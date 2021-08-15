<?php


namespace App\Service;


use App\Repository\ESRepository;
use App\Repository\MessageRepository;

class MessageService
{

    /**
     * 提交留言
     */
    public function commitMessage($user_id, $message)
    {
        //存入数据库
        $messageRepository = new MessageRepository();
        $messageRepository->save($user_id, $message);
        $messageId = $messageRepository->getMessage_id();

        $esRepository = new ESRepository();
        $esRepository->save($user_id, $message, $messageId);
    }

    /**
     * 删除留言，mysql和es都删除
     * @param $messageId
     */
    public function deleteMessage($messageId)
    {
        app(MessageRepository::class)->delete($messageId);
        app(ESRepository::class)->delete($messageId);
    }

    public function updateMessage($messageId, $newMessage)
    {
        app(MessageRepository::class)->update($messageId, $newMessage);
        app(ESRepository::class)->update($messageId, $newMessage);
    }
}