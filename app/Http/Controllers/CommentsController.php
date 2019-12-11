<?php

namespace App\Http\Controllers;

use App\Event;
use App\Comment;
use App\Http\Requests\Comments\CreateCommentRequest;

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
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Event $event)
    {
        return $event->comments()
            ->latest()
            ->paginate(10);
    }

    /**
     * Store a newly created comment in database.
     *
     * @param Event $event
     * @param CreateCommentRequest $request
     * @return mixed
     */
    public function store(Event $event, CreateCommentRequest $request)
    {
        return $event->addComment([
            'user_id' => auth()->id(),
            'body'    => request('body'),
        ])->load('owner');
    }

    /**
     * @param Comment $comment
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Comment $comment)
    {
        $this->authorize('update', $comment);

        try {
            request()->validate(['body' => 'required|spamfree']);

            $comment->update(request()->all());
        } catch (\Exception $e) {
            return response('Sorry, your comment could not be saved at this time', 422);
        }
    }

    /**
     * Delete a single comment from database.
     *
     * @param Comment $comment
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        return response(['status' => 'Comment deleted']);
    }
}
