@extends('frontend._layouts.main')

@section('breadcrumb')
<h1 class="h3 mb-3"><strong>Profile</strong></h1>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('frontend._components.notification')
        <div class="card">
            <div class="card-header">
                Change Password
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="input_current_password">Current Password</label>
                                <input type="password" id="input_current_password" class="form-control" placeholder="Enter Password" name="current_password">
                                @if($errors->first('current_password'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('current_password')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="input_password">Password</label>
                                <input type="password" id="input_password" class="form-control" placeholder="Enter Password" name="password">
                                @if($errors->first('password'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('password')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="input_password_confirmation">Confim Password</label>
                                <input type="password" id="input_password_confirmation" class="form-control" placeholder="Enter Password" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('frontend.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop