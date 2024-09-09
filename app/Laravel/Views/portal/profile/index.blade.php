@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Account Settings</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">My Profile</h6>
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <div class="col-md-12 text-center mb-2">
                        <img src="{{$auth->directory && $auth->filename ? "{$auth->directory}/{$auth->filename}" : asset('assets/images/profile/blank-profile.png')}}" alt="Profile Pic" class="img-fluid rounded-circle mb-2" width="128" height="128">
                        <h5>{{$auth->name}}</h5><hr>
                    </div>
                    <div class="col-md-6">
                        <p><b>Role</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{Helper::capitalize_text($auth->roles->pluck('name')->implode(','))}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Email</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$auth->email}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Contact</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$auth->contact_number ?? 'N/A'}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Status</b></p>
                    </div>
                    <div class="col-md-6">
                        <span class="badge badge-{{Helper::badge_status($auth->status)}}">{{Str::upper($auth->status)}}</span>
                    </div>
                </div>
                <hr>
                <a href="{{route('portal.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                <a href="{{route('portal.profile.edit_password')}}" class="btn btn-sm btn-secondary">Change Password</a>
                <a href="{{route('portal.profile.edit_profile')}}" class="btn btn-sm btn-info">Change Profile</a>
            </div>
        </div>
    </div>
</div>
@stop