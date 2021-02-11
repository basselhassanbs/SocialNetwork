@extends('layouts.app')

@section('style')
    <style>
        .border-3 {
            border-left: 3px solid;
        }

    </style>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">

        <div class="row justify-content-center border-bottom p-2">
            <div class="col-md-6">
                <h3 class="font-weight-bold">What do you have to say?</h3>
                {{-- <div class="form-group">
                    <textarea class="form-control rounded" name="post-input" id="post-input" placeholder="Your Post" rows="3"></textarea>
                </div> --}}
                <form action="/posts" method="POST">
                    @csrf

                    <div class="form-group">
                        <textarea class="form-control @error('post') is-invalid @enderror" name="post" id="post" rows="5"
                            placeholder="Your Post"></textarea>
                        @error('post')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mb-1">Create Post</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <h3 class="mb-3 font-weight-bold" id="head">What other people say...</h3>
                @forelse ($posts as $post)
                    <article class="pl-2 mb-4 border-danger border-3 post" data-postid="{{ $post->id }}">
                        <p>{{ $post->body }}</p>

                        <div class="font-italic text-muted">
                            Posted by {{ $post->user->name }} on {{ $post->created_at }} </div>
                        <div class="row pl-3 interaction">
                            @if (Auth::check())
                            <a href="#" class="like {{ $post->isLikePost(Auth::user()->id) ? 'text-primary' : 'text-dark' }}">Like</a>&nbsp; (<div class="like-count">{{ $post->likes->where('like',1)->count() }}</div>) &nbsp;|&nbsp;
                            
                            <a href="#" class="like {{ $post->isDislikePost(Auth::user()->id) ? 'text-primary' : 'text-dark' }}">Dislike</a>&nbsp; (<div class="dislike-count">{{ $post->likes->where('like',0)->count() }}</div>) 
                            
                            @endif
                            
                            @if (Auth::user() == $post->user)
                                &nbsp;|&nbsp;
                                
                                <a href="#" class="edit text-dark">Edit</a>&nbsp;|&nbsp;
                                <a href="javascript:void(0)" class="text-dark"
                                    onclick="if (confirm('Are you sure!')) { document.getElementById('delete-{{ $post->id }}').submit();} else { return false; }">
                                    Delete</a>
                                <form action="/posts/{{ $post->id }}" method="POST" id="delete-{{ $post->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            @endif
                        </div>
                    </article>

                @empty
                    <h1 class="font-weight-bold">No thing here yet!</h1>


                @endforelse
                

                <div class="modal" tabindex="-1" role="dialog" id="edit-modal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold">Edit Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-group">
                                        <label for="post-body" class="font-weight-bold">Edit the Post</label>
                                        <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="modal_save">Save changes</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal" tabindex="-1" role="dialog" id="addPostModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold">Add Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="form-group">
                                        <label for="po-body" class="font-weight-bold">Add the Post</label>
                                        <textarea class="form-control" name="po-body" id="po-body" rows="5"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="addPostModal-save">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $(".alert").delay(3000).slideUp(300);
    });
</script>
<script>
    var urlCreate = '{{ route('posts.create') }}';
</script>

@endsection
