<?php

namespace App\Http\Requests\Events;

use App\Event;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:2|spamfree',
            'description' => 'required|min:10|spamfree',
            'country' => 'required',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }


    public function persist($image_path)
    {
        return Event::create([
            'user_id'     => auth()->id(),
            'title'       => request('title'),
            'country_id'  => request('country'),
            'description' => request('description'),
            'image_path'  => $image_path,
            'start_date'  => request('start_date'),
            'end_date'    => request('end_date'),
        ]);
    }
}
