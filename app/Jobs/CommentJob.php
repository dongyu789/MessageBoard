<?php

namespace App\Jobs;

use App\Service\MessageService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $user_id;
    protected string $message;

    /**
     * 队列任务最大尝试次数
     * @var int
     */
    private $tries = 3;

    /**
     * 任务的最大超时时间
     * @var int
     */
    private $timeout = 180;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $message)
    {
        //
        $this->user_id = $user_id;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app(MessageService::class)->commitMessage($this->user_id, $this->message);
        //dd();
        //print_r('helloskldfjalkdfjasjflksjdfj');
    }
}
