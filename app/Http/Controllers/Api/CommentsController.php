<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentsCollectionResource;

/**
 * Class CommentsController
 * @package App\Http\Controllers\Api
 */
class CommentsController extends Controller
{
    /**
     * @param Event $event
     * @return CommentsCollectionResource
     */
    public function index(Event $event)
    {
        $comments =  $event->comments()
            ->latest();
//            ->paginate(10);

        return new CommentsCollectionResource($comments);
    }

    /**
     * @param Event $event
     * @return \Illuminate\Database\Eloquent\Model
     */
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

    /**
     * @param Comment $comment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        return response(['message' => 'Comment deleted']);
    }
}
