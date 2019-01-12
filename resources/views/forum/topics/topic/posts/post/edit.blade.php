@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row  justify-content-center">
        <div class="col-md-8">
            <p><a href="{{ route('forum.topics.topic.show', $topic) }}">&laquo; Back to the topic</a></p>
            <div class="card">
                <div class="card-header">Edit the post</div>

                <div class="card-body">
                    <form action="{{ route('forum.topics.topic.posts.post.update', [$topic, $post]) }}" method="post">
                        <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
                            <label for="post" class="control-label">Post</label>
                            <textarea name="post" id="post" class="form-control" rows="8" required>{{ $post->body }}</textarea>
                            @if ($errors->has('post'))
                                <div class="help-block danger">
                                    {{ $errors->first('post') }}
                                </div>
                            @endif
                            <div class="help-block pull-left">
                                Feel free to use Markdown.
                                <br />
                                Use [@username](/user/profile/@username) to mention another user here.
                            </div>
                        </div>
                        @csrf
                        <button type="submit" class="btn btn-default pull-right">Update</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
