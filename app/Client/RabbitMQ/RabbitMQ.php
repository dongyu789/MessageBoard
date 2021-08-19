<?php


namespace App\Client\RabbitMQ;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQ
{
    protected $connection;
    protected $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_LOGIN'),
            env('RABBITMQ_PASSWORD')
        );
        $this->channel = $this->connection->channel();
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function getChannel()
    {
        return $this->channel;
    }
}