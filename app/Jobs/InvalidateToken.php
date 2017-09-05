<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use JWTAuth;

class InvalidateToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\Tymon\JWTAuth\Token $token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        JWTAuth::invalidate($this->token);
        // logger('运行队列invalidateToken');
        // logger(\Carbon\Carbon::now());
    }
}
