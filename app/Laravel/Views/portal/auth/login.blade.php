@extends('portal._layouts.auth')

@section('content')
<div class="col-xl-10 col-lg-12 col-md-9">
    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img src="{{asset('assets/images/logo/everlastlogo1.png')}}" width="255" height="220" alt="Logo">
                </div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Everlast Portal Login</h1>
                        </div>
                        <form class="user" method="POST" action="">
                            @include('portal._components.notification')
                            {!!csrf_field()!!}
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="input_email" placeholder="Enter Email Address" name="email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="input_password" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck" name="remember_me">
                                    <label class="custom-control-label" for="customCheck">Remember Me</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
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