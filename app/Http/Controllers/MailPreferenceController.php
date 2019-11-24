<?php

namespace App\Http\Controllers;

use App\User;

class MailPreferenceController extends Controller
{
    public function show(User $user)
    {
        $this->authorize('update', $user);

        return view('profiles.email_preferences', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user);

        request()->validate([
            'weekly_event_mail' => 'nullable',
            'daily_event_mail' => 'nullable',
        ]);

        request()->has('daily_event_mail') ? 
            $user->subscribeToDailyMails() : 
            $user->unsubscribeFromDailyMails();
        
        request()->has('weekly_event_mail') ? 
            $user->subscribeToWeeklyMails() : 
            $user->unsubscribeFromWeeklyMails();

        return back();       
    }

    public function destroy(User $user)
    {
        $user->unsubscribeFromAllMails();

        return redirect()->route('/home')
                ->withFlash('Unsubscribed from all mails');
    }
    
}
