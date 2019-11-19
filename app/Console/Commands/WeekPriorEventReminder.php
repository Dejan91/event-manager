<?php

namespace App\Console\Commands;

use App\Event;
use App\Jobs\SendEmailWeekPrior;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Mail\WeekPriorEventMail;
use Illuminate\Support\Facades\Mail;

class WeekPriorEventReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:week-prior';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder email week prior to event start to subscribers';

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
        $events = Event::all()->filter(function ($event) {
            return $event->end_date > Carbon::now()->addDay(7);
        });

        $emails = $events->map(function ($event) {
            return $event->creator->email;
        });

        Mail::to($emails)->send(new WeekPriorEventMail());
    }
}
