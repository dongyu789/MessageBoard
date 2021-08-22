<?php


namespace App\Service;


use App\Client\RabbitMQ\RabbitMQ;
use Illuminate\Support\Facades\Redis;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    private static $rabbitmq;
    private static $channel;
    private static $receiveToMysql;
    private static $exchange;
    private static $receiveToRedis;

    //单例
    private static $rabbitMQService;

    final public function __construct()
    {
        RabbitMQService::$rabbitmq = new RabbitMQ();
        RabbitMQService::$channel = RabbitMQService::$rabbitmq->getChannel();
        RabbitMQService::$receiveToMysql = 'receiveToMysql';
        RabbitMQService::$receiveToRedis = 'receiveToRedis';
        RabbitMQService::$exchange = 'sendMessageExchange';

        //init
        RabbitMQService::$channel->exchange_declare(RabbitMQService::$exchange, 'fanout', false, true, false);
        RabbitMQService::$channel->queue_declare(RabbitMQService::$receiveToMysql, false, true, false, false);
        RabbitMQService::$channel->queue_declare(RabbitMQService::$receiveToRedis, false, true, false, false);
        RabbitMQService::$channel->queue_bind(RabbitMQService::$receiveToMysql, RabbitMQService::$exchange);
        RabbitMQService::$channel->queue_bind(RabbitMQService::$receiveToRedis, RabbitMQService::$exchange);

    }

    public static function getInstance()
    {
        if (RabbitMQService::$rabbitMQService == null) {
            RabbitMQService::$rabbitMQService = new RabbitMQService();
        }
        return RabbitMQService::$rabbitMQService;
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
        RabbitMQService::$channel->basic_publish($m, RabbitMQService::$exchange, RabbitMQService::$receiveToMysql);

    }

    /**
     * 接收到有人发送留言，存储到Mysql,会同步到ES
     */
    public function receiveToMysql()
    {
        $callback = function ($msg) {
            $body = json_decode($msg->body, true);

            $userId = $body['userId'];
            $message = $body['message'];
            app(MessageService::class)->commitMessage($userId, $message);
        };

        RabbitMQService::$channel->basic_consume(RabbitMQService::$receiveToMysql, '', false, true, false, false, $callback);

        while (count(RabbitMQService::$channel->callbacks)) {
            echo "waiting...\n";
            RabbitMQService::$channel->wait();
            echo "ok\n";
        }

    }



    /**
     * 接收到有人发送留言，存储到Redis
     */
    public function receiveToRedis()
    {
        $callback = function ($msg) {
            //缓存增加
            $body = json_decode($msg->body, true);
            $userId = $body['userId'];
            Redis::hincrby('user:'.$userId, 'messageCount', 1);
        };

        RabbitMQService::$channel->basic_consume(
            RabbitMQService::$receiveToRedis,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while (count(RabbitMQService::$channel->callbacks)) {
            echo "waiting...\n";
            RabbitMQService::$channel->wait();
            echo "ok\n";
        }


    }


}