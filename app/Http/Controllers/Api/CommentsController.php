<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentsResource;
use App\Http\Requests\Comments\CreateCommentRequest;
use App\Http\Resources\ResourceIncludes\CommentResourceIncludes;

/**
 * Class CommentsController
 * @package App\Http\Controllers\Api
 */
class CommentsController extends Controller
{
    /**
     * @var CommentResourceIncludes
     */
    protected $includes;

    /**
     * CommentsController constructor.
     * @param CommentResourceIncludes $includes
     */
    public function __construct(CommentResourceIncludes $includes)
    {
        $this->includes = $includes;
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Event $event)
    {
        $comments =  $event->comments()
            ->latest();

        return CommentsResource::collection(
            $this->includes->attach($comments->paginate(15))
        );
    }

    /**
     * @param Event $event
     * @param CreateCommentRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse
     */
    public function store(Event $event, CreateCommentRequest $request)
    {
        if ($event->locked) {
            return response(['message' => 'Event is locked'], 422);
        }

        $comment = $event->addComment([
            'user_id' => auth()->id(),
            'body'    => request('body'),
        ])->load('owner');

        return response()->json([
            'message' => 'Your comment has been posted',
            'data' => new CommentsResource($comment),
        ]);
    }

    /**
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Comment $comment)
    {
        $this->authorize('update', $comment);

        try {
            request()->validate(
                ['body' => 'required|spamfree']
            );

            $comment->update(request()->all());

            return response()->json(['message' => 'Comment updated']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Sorry, your comment could not be saved at this time'], 422);
        }
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
