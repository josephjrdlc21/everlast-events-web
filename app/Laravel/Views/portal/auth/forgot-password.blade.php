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
                            <h1 class="h4 text-gray-900 mb-4">{{$settings->brand_name ?? 'Brand Name'}} Forgot Password</h1>
                        </div>
                        <form class="user" method="POST" action="">
                            @include('portal._components.notification')
                            {!!csrf_field()!!}
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="input_email" placeholder="Enter Email Address" name="email">
                            </div>
                            @if($errors->first('email'))
                            <small class="d-block mt-1 text-danger">{{$errors->first('email')}}</small>
                            @endif
                            <button type="submit" class="btn btn-primary btn-user btn-block">Submit Request</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{route('portal.auth.login')}}">Already have an account?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop