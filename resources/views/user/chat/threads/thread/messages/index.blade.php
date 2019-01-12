@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Messages with <a href="{{ route('user.profile.index', $recipient) }}">{{ '@' . $recipient->name }}</a></div>

                <div class="card-body">
                    <messaging-component recipient="{{ $recipient }}"></messaging-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
