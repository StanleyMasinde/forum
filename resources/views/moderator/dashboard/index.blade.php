@extends('layouts.app')
@section('title', 'Moderator Dashboard')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reports to moderate</div>
                <div class="card-body table-responsive">
                    @if (count($reports))
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Reporter</th> <th>Type</th> <th>Excerpt</th> <th></th> <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td><a href="{{ route('user.profile.index', $report->user->name) }}">{{ '@' . $report->user->name }}</a></td>
                                        <td>{{ $report->isPost() ? 'Post' : 'Topic' }}</td>
                                        @if ($report->contentExists())
                                            <td>"{{ $report->isPost() ? ((strlen($report->getPostBody($report->content_id)) >= 25) ? str_limit($report->getPostBody($report->content_id), 24) . '&ellip;' : $report->getPostBody($report->content_id)) : $report->getTopicSlug() }}"</td>
                                            <td><a href="/forum/topics/{{ $report->isPost() ? $report->getTopicForPost($report->content_id) . '#post-' . $report->content_id : $report->getTopicSlug() }}">Link</a></td>
                                        @else
                                            <td>Unavailable</td>
                                            <td>Unavailable</td>
                                        @endif
                                        <td><delete-report report-id="{{ $report->id }}"></delete-report></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p>You may delete posts or topics that have an excerpt and link of 'Unavailable'.</p>
                    @else
                        <p>Good News! There is nothing to moderate.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin contacts</div>
                <div class="card-body">
                    @if (Auth::user()->role === 'admin')
                        <p>You have the power!<br />Feel free to head over to the <a href="{{ route('admin.dashboard.index') }}">admin dashboard</a> and remove any users that are abusing the system.</p>
                    @else
                        @if (count($admins))
                            <p>Contact an administrator if you feel that a user is abusing the reporting system:</p>
                            @foreach ($admins as $admin)
                                <p><a href="{{ route('user.chat.threads.index') }}?recipient={{ $admin->name }}">{{ $admin->name }}</a></p>
                            @endforeach
                        @else
                            <p>Contact the entity that installed this applicationm, telling them that there are no administrative accounts.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
