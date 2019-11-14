<div class="card mt-3">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="#">
                    {{ $comment->owner->name }}
                </a> said {{ $comment->created_at->diffForHumans() }}...
            </h5>
        </div>
    </div>

    <div class="card-body">
        
        <div class="row">
            <div class="col-md-12">
                {{ $comment->body }}
            </div>
        </div>
        <div class="row mt-3">
            <div class="ml-auto">
                <form action="" class="mb-2">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-secondary btn-sm">Edit</button>     
                </form>
                <form action="{{ url("/comments/delete/{$comment->id}") }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>     
                </form>                             
            </div>
        </div>
    </div>
</div>