<?php

namespace App\Http\Controllers;

use App\Event;
use App\Comment;

/**
 * Class CommentsController
 * @package App\Http\Controllers
 */
class CommentsController extends Controller
{
    /**
     * Return all comments for given event.
     *
     * @param Event $event
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        return $event->comments()->paginate(10);
    }

    /**
     * Store a newly created comment in database.
     *
     * @param Event $event *
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Event $event)
    {
        request()->validate(
            [
                'body' => 'required',
            ]
        );

        $comment = $event->addComment(
            [
                'user_id' => auth()->id(),
                'body'    => request('body'),
            ]
        );

        if (request()->expectsJson()) {
            return $comment->load('owner');
        }

        return back();
    }

    /**
     * Delete a single comment from database.
     *
     * @param Comment $comment
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

    /**
     * @param Comment $comment
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update(request()->all());
    }
}
