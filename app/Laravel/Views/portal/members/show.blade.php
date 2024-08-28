@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Members</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Member Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-2">
                            <h6><b>Firstname</b></h6>
                            <p>{{$member->firstname}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Middlename</b></h6>
                            <p>{{$member->middlename ?: 'N/A'}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Lastname</b></h6>
                            <p>{{$member->lastname}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Suffix</b></h6>
                            <p>{{$member->suffix ?: 'N/A'}}</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-2">
                            <h6><b>Email</b></h6>
                            <p>{{$member->email}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Contact No.</b></h6>
                            <p>{{$member->contact_number}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Status</b></h5>
                            <p><span class="badge badge-{{Helper::badge_status($member->status)}}">{{Str::upper($member->status)}}</span></p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Date Created</b></h6>
                            <p>{{$member->created_at->format("m/d/Y h:i A")}}</p>
                        </div>
                    </div>
                </div>
                <hr>
                <a href="{{route('portal.members.index')}}" class="btn btn-sm btn-secondary">Close</a>
            </div>
        </div>
    </div>
</div>
@stop