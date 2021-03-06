<?php

namespace App\Console\Commands;

use App\Event;
use Carbon\Carbon;
use App\Jobs\DailyMail;
use Illuminate\Console\Command;

class DayPriorEventReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:day-prior';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder email day prior to event start to subscribers';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = Event::all()->filter(
            function ($event) {
                return Carbon::parse($event->start_date)->format('y m d') <= Carbon::now()->addDay()->format('y m d') &&
                       $event->subscription->count();
            }
        );

        $events->each(
            function ($event) {
                $event->subscription->each(
                    function ($sub) {
                        if ($sub->user->wantsDailyMail()) {
                            DailyMail::dispatch($sub);
                            sleep(10);
                        }
                    }
                );
            }
        );
    }
}
