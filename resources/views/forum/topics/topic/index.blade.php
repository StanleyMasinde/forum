@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <p><a href="{{ route('home.index') }}">&laquo; Back to your topics</a></p>
            <div class="card">
                <div class="card-header text-center">
                        <report-topic-button topic-slug="{{ $topic->slug }}" class="pull-right report-text report-topic"></report-topic-button> <br>
                        <h4>{{ $topic->title }}</h4>
                        {{ Carbon\Carbon::createFromTimeStamp(strtotime($topic->created_at))->diffForHumans() }} by <a href="/user/profile/{{ '@' . App\User::findOrFail($topic->user_id)->name }}">{{ '@' . App\User::findOrFail($topic->user_id)->name }}</a>
                        <br />
                        @can ('delete', $topic)
                            <form action="{{ route('forum.topics.topic.delete', $topic) }}" method="post">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn text-danger btn-link"><i class="fa fa-remove" aria-hidden="true"></i> Delete</button>
                            </form>
                        @endcan
                        @if (Auth::check())
                            <subscribe-button slug="{{ $topic->slug }}"></subscribe-button>
                        @endif
                        <br />
                        <span class="pull-right badge badge-secondary">{{ count($topic->posts) }}</span>
                        <br/>
                    </div>
                

                <div class="card-body">
                        @if (count($topic->posts))
                        @foreach ($topic->posts as $post)
                        <div class="card">
                            <div class="card-body">
                                <report-post-button topic-slug="{{ $topic->slug }}" post-id="{{ $post->id }}" class="pull-right report-text"></report-post-button>
                                <div class="post" id="post-{{ $post->id }}">
                                    <img src="{{ $post->user->avatar ?  asset('storage/'.$post->user->avatar) : asset('img/default-avatar.png') }}" width="60" height="60" class="rounded-circle pull-left" alt="{{ $topic->title }} image"/> <span class="pull-left">{{ Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }} by <a href="/user/profile/{{ '@' . $user = App\User::findOrFail($post->user_id)->name }}"></a> <a href="/user/profile/{{ '@' . $user = App\User::findOrFail($post->user_id)->name }}">{{ '@' . $user = App\User::findOrFail($post->user_id)->name }}</a></span>
                                    <br/><br/><br/>
                                    <p>
                                            {!! GrahamCampbell\Markdown\Facades\Markdown::convertToHtml(
                                                $post->body
                                            ) !!}
                                    </p>
                                    <form class="inline" action="{{ route('forum.topics.topic.posts.post.delete', [$topic, $post]) }}" method="post">
                                    @can ('update', $post)
                                        <a href="{{ route('forum.topics.topic.posts.post.edit', [$topic, $post]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                                    @endcan
                                    @can ('delete', $post)
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn text-danger btn-link"><i class="fa fa-remove" aria-hidden="true"></i> Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <br>
                        @endforeach
                    @else
                        <p>The are currently no posts for this topic.</p>
                    @endif

                    <br />
                    @if (Auth::check())
                        <form action="{{ route('forum.topics.posts.create.submit', $topic) }}" method="post">
                            @csrf
                            <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
                                <label for="post" class="control-label">Your Reply</label>
                                <textarea name="post" id="post" class="form-control" placeholder="Your reply to {{ $topic->title }}" rows="8"></textarea>
                                @if ($errors->has('post'))
                                    <div class="help-block danger">
                                        {{ $errors->first('post') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-text pull-left">
                                Feel free to use Markdown. Use @username to mention another user.
                            </div>
                            <button type="submit" class="btn btn-default pull-right">Add Reply</button>
                        </form>
                    @else
                        <p style="text-align: center">Please <a href="{{ url('/register') }}">register</a> and <a href="{{ url('/login') }}">login</a> to join the conversation.</p>
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
