@extends('frontend._layouts.main')

@section('breadcrumb')
<h1 class="h3 mb-3"><strong>My Profile</strong></h1>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('frontend._components.notification')
        <div class="card">
            <div class="card-header">
                Profile Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center mb-2">
                        <img src="{{$auth->directory && $auth->filename ? "{$auth->directory}/{$auth->filename}" : asset('assets/images/profile/blank-profile.png')}}" alt="Profile Pic" class="img-fluid rounded-circle mb-2" width="128" height="128">
                        <h5>{{$auth->name}}</h5>
                    </div><hr>
                    <div class="col-md-6">
                        <p><b>Email</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$auth->email}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Status</b></p>
                    </div>
                    <div class="col-md-6">
                        <span class="badge bg-{{Helper::badge_status($auth->status)}}">{{Str::upper($auth->status)}}</span>
                    </div>
                    <div class="col-md-6">
                        <p><b>Contact</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$auth->contact_number}}</p>
                    </div><hr>
                </div>
                <a href="{{route('frontend.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                <a href="{{route('frontend.profile.edit_password')}}" class="btn btn-sm btn-secondary">Change Password</a>
                <a href="{{route('frontend.profile.edit_profile')}}" class="btn btn-sm btn-info">Change Profile</a>
            </div>
        </div>
    </div>
</div>
@stop