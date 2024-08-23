@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Account Management</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><b>ID</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{str_pad($user->id, 5, "0", STR_PAD_LEFT)}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Role</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{Helper::capitalize_text($user->roles->pluck('name')->implode(','))}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Name</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$user->name}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Email</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$user->email}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Status</b></p>
                    </div>
                    <div class="col-md-6">
                        <span class="badge badge-{{Helper::badge_status($user->status)}}">{{Str::upper($user->status)}}</span>
                    </div>
                </div>
                <hr>
                <a href="{{route('portal.users.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                @if($auth->canAny(['portal.users.edit_password'], 'portal'))
                <a href="{{route('portal.users.edit_password', [$user->id])}}" class="btn btn-sm btn-secondary">Reset Password</a>
                @endif
                @if($auth->canAny(['portal.users.update'], 'portal'))
                <a href="{{route('portal.users.edit', [$user->id])}}" class="btn btn-sm btn-info">Edit</a>
                @endif
            </div>
        </div>
    </div>
</div>
@stop