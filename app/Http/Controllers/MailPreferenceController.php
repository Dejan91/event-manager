<?php

namespace App\Http\Controllers;

use App\User;
use App\UnsubscribeToken;

/**
 * Class MailPreferenceController
 * @package App\Http\Controllers
 */
class MailPreferenceController extends Controller
{
    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('profiles.email_preferences', compact('user'));
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user)
    {
        $this->authorize('update', $user);

        request()->validate(
            [
                'weekly_event_mail' => 'nullable',
                'daily_event_mail'  => 'nullable',
            ]
        );

        request()->has('daily_event_mail') ? $user->subscribeToDailyMails() : $user->unsubscribeFromDailyMails();

        request()->has('weekly_event_mail') ? $user->subscribeToWeeklyMails() : $user->unsubscribeFromWeeklyMails();

        return back();
    }

    /**
     * @param User             $user
     * @param UnsubscribeToken $unsubscribeToken
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $user, UnsubscribeToken $unsubscribeToken)
    {
        if (!$this->validToken($unsubscribeToken, $user)) {
            return redirect('/home')->withErrors(['message' => 'Wrong token']);
        }

        $user->unsubscribeFromAllMails();

        $unsubscribeToken->delete();

        return redirect('/home')->withFlash('Unsubscribed from all mails');
    }

    /**
     * @param $unsubscribeToken
     * @param $user
     *
     * @return bool
     */
    protected function validToken($unsubscribeToken, $user)
    {
        return $unsubscribeToken->token === $user->unsubscribeToken->first()->token;
    }
}
