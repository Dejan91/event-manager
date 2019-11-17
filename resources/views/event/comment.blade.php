<comment :attributes="{{ $comment }}" inline-template v-cloak>
    <div class="card mt-3">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a href="#">
                        {{ $comment->owner->name }}
                    </a> said {{ $comment->created_at->diffForHumans() }}...
                </h5>

                <div>
                    <form method="POST" action="{{ "/favorite/" . strtolower(class_basename($comment)) . "/{$comment->id}" }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary" {{ $comment->isFavorited() ? 'disabled' : '' }}>
                            {{ $comment->favorites_count }} {{ Str::plural('Favorite', $comment->favorites_count) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            
            <div class="row">
                <div class="col-md-12" v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>
                    <button class="btn btn-sm btn-primary float-right" @click="update">Update</button>
                    <button class="btn btn-sm btn-link float-right" @click="editing = false">Cancel</button>
                </div>                  
                
                <div class="col-md-12" v-else v-text="body" ></div>
            </div>
            @can('update', $comment)
                <div class="row mt-3">
                    <div class="ml-auto">
                        <button class="btn btn-secondary btn-sm " @click="editing = true">Edit</button>
                        <button class="btn btn-sm btn-danger ml-1 mr-3" @click="destroy">Delete</button>
                    </div>
                </div>
            @endcan
        </div>
    </div>
</comment>