@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form action="{{ route('forum.topics.create.submit') }}" method="post">
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="control-label">Topic Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ (old('title') ? old('title') : '' ) }}" placeholder="Halt! Crocs?">
                            @if ($errors->has('title'))
                                <div class="text-danger">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <div class="help-block">
                                <p>All titles need to be unique.</p>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
                            <label for="post" class="control-label">Your Post</label>
                            <textarea name="post" id="post" class="form-control" placeholder="What is your opinion on crocs?" rows="8">{{ (old('post') ? old('post') : '' ) }}</textarea>
                            @if ($errors->has('post'))
                                <div class="text-danger">
                                    {{ $errors->first('post') }}
                                </div>
                            @endif
                        </div>
                        <div class="help-block pull-left">
                            Feel free to use Markdown.
                        </div>
                        <div class="form-group checkbox pull-right">
                            <label for="subscribe">
                                <input type="checkbox" name="subscribe" id="subscribe" style="margin-top:4px; padding: 8px" checked> &nbsp; Subscribe to topic?
                            </label>
                        </div>
                        <br />
                        <br />
                        @csrf
                        <button type="submit" class="btn btn-success pull-right">Create Topic</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
