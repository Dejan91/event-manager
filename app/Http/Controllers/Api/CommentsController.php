<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Event;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function store(Event $event)
    {
        request()->validate([
            'body' => 'required',
        ]);

        return $event->addComment([
            'user_id' => auth()->id(),
            'body'    => request('body'),
        ])->load('owner');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        return response(['message' => 'Comment deleted']);
    }
}
