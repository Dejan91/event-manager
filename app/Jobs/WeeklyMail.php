<?php

namespace App\Jobs;

use App\EventSubscription;
use Illuminate\Bus\Queueable;
use App\Mail\WeekPriorEventMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class WeeklyMail
 * @package App\Jobs
 */
class WeeklyMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $tries = 2;

    /**
     * @var EventSubscription
     */
    protected $subscription;

    /**$subscription
     * Create a new job instance.
     *
     * @param EventSubscription $subscription
     */
    public function __construct(EventSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->subscription->user->email)->send(new WeekPriorEventMail($this->subscription->user));
    }
}
