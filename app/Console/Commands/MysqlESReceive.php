<?php

namespace App\Console\Commands;

use App\Service\RabbitMQService;
use Illuminate\Console\Command;

class MysqlESReceive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:mysql';

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
        //持久化到Mysql和ES,加入守护进程
        //echo 'queue:OK';
        $rabbitmqService = RabbitMQService::getInstance();
        $rabbitmqService->receiveToMysql();

    }
}
