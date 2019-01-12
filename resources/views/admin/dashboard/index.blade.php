@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Invite users</div>
                <div class="card-body">
                    <form class="form-row" action="{{ route('admin.dashboard.invite') }}" method="post">
                        <div class="form-group col-md-6{{ $errors->has('inviteeEmail') ? ' invalid' : '' }}">
                            <label for="inviteeEmail" class="control-label">Email address of invitee</label>
                            <input type="email" name="inviteeEmail" id="inviteeEmail" class="form-control" value="{{ (old('inviteeEmail') ? old('inviteeEmail') : '' ) }}" placeholder="Enter the email address of invitee">
                            @if ($errors->has('inviteeEmail'))
                                <div class="text-danger">
                                    {{ $errors->first('inviteeEmail') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-4{{ $errors->has('inviteeRole') ? ' has-error' : '' }}">
                            <label for="inviteeRole" class="control-label">Role of invitee</label>
                            <select name="inviteeRole" id="inviteeRole" class="form-control">
                                    <option value="user">user</option>
                                    <option value="moderator">moderator</option>
                                    <option value="admin">admin</option>
                            </select>
                            @if ($errors->has('inviteeRole'))
                                <div class="text-danger">
                                    {{ $errors->first('inviteeRole') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            @csrf
                            <button type="submit" class="btn btn-primary">Invite</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
     </div>

    @if (count($users))
        <modify-users users-prop="{{ $users }}"></modify-users>
    @endif

</div>
@endsection
