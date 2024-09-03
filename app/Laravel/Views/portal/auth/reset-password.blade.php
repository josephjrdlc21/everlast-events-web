@extends('portal._layouts.auth')

@section('content')
<div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img src="{{isset($settings) ? "{$settings->directory}/{$settings->filename}" : ""}}" width="255" height="220" alt="Logo">
                </div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">{{$settings->brand_name ?? 'Brand Name'}} Reset Password</h1>
                        </div>
                        <form class="user" method="POST" action="">
                            @include('portal._components.notification')
                            {!!csrf_field()!!}
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="input_password" placeholder="Password" name="password">
                                @if($errors->first('password'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('password')}}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="input_password_confirmation" placeholder="Confirm Password" name="password_confirmation">
                                @if($errors->first('password_confirmation'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('password_confirmation')}}</small>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{route('portal.auth.register')}}">Create an Account!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop