<?php

namespace App\Http\Controllers;

use App\Event;
use App\Comment;

class CommentsController extends Controller
{

    /**
     * Store a newly created comment in database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Event $event)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $comment = $event->addComment([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);

        if (request()->expectsJson()) {
            return $comment->load('owner');
        }
        
        return back();
    }

    /**
     * Delete a single comment from database.
     * 
     * @param Comment $comment
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Comment deleted']);
        }

        return back();
    }

    public function update(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update(request()->all());
    }
    
}
