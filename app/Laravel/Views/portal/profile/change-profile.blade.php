@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-9 col-lg-7 col-xl-5">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Change Profile Picture</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12 text-center mb-2">
                            <img src="{{$auth->directory && $auth->filename ? "{$auth->directory}/{$auth->filename}" : asset('assets/images/profile/blank-profile.png')}}" alt="Profile Pic" class="img-fluid rounded-circle mb-2" width="128" height="128">
                            <h5>{{$auth->name}}</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_image">Change Profile</label>
                                <input class="form-control pb-5" type="file" id="input_image" name="profile_image" value="{{old('profile_image')}}">
                                @if($errors->first('profile_image'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('profile_image')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('portal.profile.index')}}" class="btn btn-sm btn-secondary">Close</a>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop