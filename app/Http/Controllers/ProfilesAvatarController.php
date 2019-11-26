<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProfilesAvatarController extends Controller
{
    public function update(User $user)
    {
        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        Storage::delete('public/' . $user->getOriginal('avatar_path'));
        Storage::delete('public/' . $user->getOriginal('thumb_path'));

        $avatar_path = request()->file('avatar')->store('user_avatars', 'public');

        $path = request()->file('avatar')->hashName('public/user_thumbs/');
        $thumb = Image::make(request()->file('avatar'))->resize(50, 50);
        $thumb_path = Str::after($path, 'public/');

        Storage::put($path, $thumb->encode());

        $user->update([
            'avatar_path' => $avatar_path,
            'thumb_path' => $thumb_path,
        ]);

        return back()
            ->withFlash('Avatar changed');
    }
}
