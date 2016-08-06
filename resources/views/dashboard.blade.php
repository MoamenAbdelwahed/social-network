@extends('layouts.master')

@section('content')
	@include('includes.messages-block')
	<section class="row new-post">
		<div class="col-md-6 col-md-offset-3">
			<header><h3>What do you have to say?</h3></header>
			<form action="{{ route('post.create') }}" method="post">
				<div class="form-group">
					<textarea class="form-control" name="body" rows="5" placeholder="your post"></textarea>
				</div>
				<button class="btn btn-primary" type="submit">Create Post</button>
				<input type="hidden" value="{{ Session::token() }}" name="_token"> 
			</form>
		</div>
	</section>
	<section class="row posts">
		<div class="col-md-6 col-md-offset-3">
			<header><h3>What other people say...</h3></header>
			<ul class="media-list">
			@foreach($posts as $post)
			<article class="post" data-postid="{{ $post->id }}">
			<li class="media">
				@if (Storage::disk('local')->has($post->user->first_name . '-' . $post->user->id . '.jpg'))
				<div class="media-left">
				    <a href="#">
				      <img class="media-object img-circle" width="64" height="64" src="{{ route('account.image', ['filename' => $post->user->first_name . '-' . $post->user->id . '.jpg']) }}" alt="His image">
				    </a>
				</div>
				@endif

				<div class="media-body">
					<p>{{ $post->body }}</p>
					<div class="info">Posted by {{$post->user->first_name }} on {{ $post->created_at }}</div>
					<div class="interaction">
						<a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'  }}</a> |
						<a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don\'t like this post' : 'Dislike' : 'Dislike'  }}</a> |
						<a href="#" class="comment">Comment</a> |
						@if(Auth::user() == $post->user)
						<a href="#" class="edit">Edit</a> |
						<a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
						@endif
					</div>

					@foreach($post->comments as $comment)
					<div class="media">
						@if (Storage::disk('local')->has($comment->user->first_name . '-' . $comment->user->id . '.jpg'))
						<div class="media-left">
						    <a href="#">
						      <img class="media-object img-circle" width="64" height="64" src="{{ route('account.image', ['filename' => $comment->user->first_name . '-' . $comment->user->id . '.jpg']) }}" alt="His image">
						    </a>
						</div>
						@endif
					    <div class="media-body">
					    	<p>{{ $comment->body }}</p>
							<div class="info">Comment by {{$comment->user->first_name }} on {{ $comment->created_at }}</div>
					    </div>
					</div>
					@endforeach
				</div>
			</li>
			</article>
			@endforeach
			</ul>
		</div>
	</section>

<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Post</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="post-body">Edit the Post</label>
                        <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="comment-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Type your comment</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="comment-body">comment here...</label>
                        <textarea class="form-control" name="comment-body" id="comment-body" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="comment-save">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	var token = '{{ Session::token() }}';
	var currentUser = '{{ Auth::user()->id }}';
	var urlEdit = '{{ route('edit') }}';
	var urlComment = '{{ route('comment') }}';
	var urlLike = '{{ route('like') }}';
</script>
@endsection