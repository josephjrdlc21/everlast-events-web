@extends('frontend._layouts.main')

@section('breadcrumb')
<h1 class="h3 mb-3"><strong>My Profile</strong></h1>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-9 col-lg-7 col-xl-5">
        @include('frontend._components.notification')
        <div class="card">
            <div class="card-header">
               Change Profile Picture
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
                            <label for="input_image">Change Profile</label>
                            <input class="form-control" type="file" id="input_image" name="profile_image" value="{{old('profile_image')}}">
                            @if($errors->first('profile_image'))
                            <small class="d-block mt-1 text-danger">{{$errors->first('profile_image')}}</small>
                            @endif
                        </div>
                    </div>        
                    <hr>
                    <a href="{{route('frontend.profile.index')}}" class="btn btn-sm btn-secondary">Close</a>
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop