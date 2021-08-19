<?php


namespace App\Service;


use App\Client\RabbitMQ\RabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    private $rabbitmq;
    private $channel;
    private $receiveToMysql;

    public function __construct()
    {
        $this->rabbitmq = new RabbitMQ();
        $this->channel = $this->rabbitmq->getChannel();
    }

    public function init()
    {
        //只需要执行一次
        $this->receiveToMysql = 'receiveToMysql';
        $this->receiveToRedis = 'receiveToRedis';

        $exchange = 'sendMessageExchange';

        $this->channel->exchange_declare($exchange, 'fanout', false, true, false);

        $this->channel->queue_declare($this->receiveToMysql, false, true, false, false);
        $this->channel->queue_declare($this->receiveToRedis, false, true, false, false);

        $this->channel->queue_bind($this->receiveToMysql, $exchange);
        $this->channel->queue_bind($this->receiveToRedis, $exchange);

    }

    /**
     * 有人发送留言，推送到指定queue
     */
    public function sendMessage($userId, $message)
    {
        $msg = [
            'userId' => $userId,
            'message' => $message
        ];
        $m = new AMQPMessage(json_encode($msg));
        $this->channel->basic_publish($m);

    }

    /**
     * 接收到有人发送留言，存储到Mysql,会同步到ES
     */
    public function receiveToMysql()
    {

        $callback = function ($msg) {
            $body = json_decode($msg->body);
            $userId = $body['userId'];
            $message = $body['message'];
            app(MessageService::class)->commitMessage($userId, $message);
        };

        $this->channel->basic_consume($this->receiveToMysql, '', false, true, false, false, $callback);

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }

    }



    /**
     * 接收到有人发送留言，存储到Redis
     */
    public function receiveToRedis()
    {

    }


}