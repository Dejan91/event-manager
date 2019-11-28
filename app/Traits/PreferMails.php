<?php

namespace App\Traits;

use App\MailType;

/**
 * Trait PreferMails
 * @package App\Traits
 */
trait PreferMails
{
    /**
     * @return mixed
     */
    public function mailTypes()
    {
        return $this->belongsToMany(MailType::class);
    }

    /**
     * @return bool
     */
    public function wantsWeeklyMail()
    {
        return !!$this->mailTypes->filter(
            function ($mailType) {
                return $mailType->name === 'event_weekly';
            }
        )->count();
    }

    /**
     * @return bool
     */
    public function wantsDailyMail()
    {
        return !!$this->mailTypes->filter(
            function ($mailType) {
                return $mailType->name === 'event_daily';
            }
        )->count();
    }

    /**
     *
     */
    public function subscribeToDailyMails()
    {
        if (!$this->wantsDailyMail()) {
            $this->mailTypes()->attach(
                    [
                        'mail_type_id' => 1,
                    ]
                );
        }
    }

    /**
     *
     */
    public function unsubscribeFromDailyMails()
    {
        if ($this->wantsDailyMail()) {
            $this->mailTypes()->detach(
                    [
                        'mail_type_id' => 1,
                        'user_id'      => auth()->id(),
                    ]
                );
        }
    }

    /**
     *
     */
    public function subscribeToWeeklyMails()
    {
        if (!$this->wantsWeeklyMail()) {
            $this->mailTypes()->attach(
                    [
                        'mail_type_id' => 2,
                    ]
                );
        }
    }

    /**
     *
     */
    public function unsubscribeFromWeeklyMails()
    {
        if ($this->wantsWeeklyMail()) {
            $this->mailTypes()->detach(
                    [
                        'mail_type_id' => 2,
                        'user_id'      => auth()->id(),
                    ]
                );
        }
    }

    /**
     *
     */
    public function unsubscribeFromAllMails()
    {
        $this->mailTypes()->detach();
    }
}
