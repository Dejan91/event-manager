<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class EventReceivedNewComment
{
    use Dispatchable, SerializesModels;

    public $comment;

    /**
     * EventReceivedNewComment constructor.
     * @param $comment
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }
}
