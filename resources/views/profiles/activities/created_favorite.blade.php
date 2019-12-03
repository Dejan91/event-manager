<div class="text">
    Favorited
    <a href="{{ $activity->subject->favoritable->path() }}">
        {{ \Illuminate\Support\Str::after($activity->subject->favoritable_type, 'App\\') }}
    </a>
</div>
