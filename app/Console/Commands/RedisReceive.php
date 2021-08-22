<?php

namespace App\Console\Commands;

use App\Service\RabbitMQService;
use Illuminate\Console\Command;

class RedisReceive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:redis';

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
        $rabbitmqService = RabbitMQService::getInstance();
        $rabbitmqService->receiveToRedis();
    }
}
