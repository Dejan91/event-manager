<?php

namespace App\Http\Requests\Comments;

use App\Comment;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateCommentForm
 * @package App\Http\Requests\Comments
 */
class CreateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Comment());
    }

    /**
     * @throws ThrottleException
     */
    protected function failedAuthorization()
    {
        throw new ThrottleException(
            'You can leave a comment only once per minute'
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree',
        ];
    }

    public function persist($event)
    {

    }
}
