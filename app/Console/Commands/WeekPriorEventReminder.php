<?php

namespace App\Console\Commands;

use App\Event;
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = Event::all()->filter(function ($event) {
            return Carbon::parse($event->start_date)->format('y m d') == Carbon::now()->addDay(7)->format('y m d') && $event->subscription->count();
        });

        $events->each(function ($event) {
            $event->subscription->each(function ($sub) {
                if ($sub->user->wantsWeeklyMail) {
                    Mail::to($sub->user->email)->send(new WeekPriorEventMail());
                }
            });
        });
    }
}
