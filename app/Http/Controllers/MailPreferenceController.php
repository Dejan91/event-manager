<?php

namespace App\Http\Controllers;

use App\User;
use App\Event;

class MailPreferenceController extends Controller
{
    public function show(User $user)
    {
        return view('emails.preferences.show', compact('user'));
    }

    public function update()
    {
        request()->validate([
            'weekly_event_mail' => 'nullable',
            'daily_event_mail' => 'nullable',
        ]);

        request()->has('daily_event_mail') ? $this->subscribe(1) : $this->unsubscribe(1);
        request()->has('weekly_event_mail') ? $this->subscribe(2) : $this->unsubscribe(2);

        return back();
       
    }
    
    protected function subscribe($mailType)
    {
        auth()->user()
            ->mailTypes()
            ->attach([
                'mail_type_id' => $mailType,
                'user_id' => auth()->id(),
                ]);
    }

    protected function unsubscribe($mailType)
    {
        auth()->user()
            ->mailTypes()
            ->detach([
                'mail_type_id' => $mailType,
                'user_id' => auth()->id(),
                ]);
    }
}
