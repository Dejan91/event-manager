<?php

namespace App\Mail;

use App\User;
use App\UnsubscribeToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WeekPriorEventMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $unsubscribeToken;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->unsubscribeToken = UnsubscribeToken::generateFor($user);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.event.week-prior');
    }
}
