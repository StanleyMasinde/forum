@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Wiki Forum</div>

                <div class="card-body">
                    <a href="{{ route('forum.topics.create.form') }}" class="btn btn-primary btn-block">Create a topic</a>
                    <div class="">
                        @if (count($topics) !== 0)
                            @foreach ($topics as $topic)
                                <div class="card text-center">
                                    <div class="card-body">
                                        <a href="/forum/topics/{{ $topic->slug }}">{{ $topic->title }} <span class="badge badge-primary">{{ count($topic->posts) }}</span></a>
                                        <br />
                                        <strong>Created</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($topic->created_at))->diffForHumans() }}
                                        <br/>
                                        @php $lastPost = DB::table('posts')->where('topic_id', $topic->id)->orderBy('created_at','desc')->take(1)->get();
                                        @endphp
                                        @foreach ($lastPost as $item)
                                        <strong>Last post</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($item->updated_at))->diffForHumans() }}
                                        @endforeach
                                        @can ('delete', $topic)
                                            <form action="{{ route('forum.topics.topic.delete', $topic) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link text-danger"><i class="fa fa-remove" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div> <br>
                            @endforeach
                        @else
                            <p>There are currently no topics listed in the forum.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
