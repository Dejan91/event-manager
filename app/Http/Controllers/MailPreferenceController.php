<?php

namespace App\Http\Controllers;

use App\User;
use App\UnsubscribeToken;

class MailPreferenceController extends Controller
{
    public function edit(User $user)
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

    public function destroy(User $user, UnsubscribeToken $unsubscribeToken)
    {
        if (! $this->validToken($unsubscribeToken, $user)) {
            return redirect('/home')
                ->withErrors(['message' => 'Wrong token']);
        }
        
        $user->unsubscribeFromAllMails();

        $unsubscribeToken->delete();
        
        return redirect('/home')
            ->withFlash('Unsubscribed from all mails');
    }

    protected function validToken($unsubscribeToken, $user)
    {
        return $unsubscribeToken->token === $user->unsubscribeToken->first()->token;
    }
    
}
