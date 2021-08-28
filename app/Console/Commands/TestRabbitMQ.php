<?php

namespace App\Console\Commands;

use App\Service\RabbitMQService;
use Illuminate\Console\Command;

class TestRabbitMQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:RabbitMQ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $rabbitmq = RabbitMQService::getInstance();

        $start = time();
        for ($i = 0; $i < 1000; $i++) {
            $rabbitmq->sendMessage('111111', $i);
        }
        $end = time();
        echo "Rabbitmq插入1000条数据用时：".($end-$start);
    }
}
