@extends('frontend._layouts.auth')

@section('content')
<div class="row vh-100">
    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
                <h1 class="h2">Welcome!</h1>
                <p class="lead">
                    Sign in to your account to continue
                </p>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="m-sm-4">
                        <div class="text-center">
                            <img src="{{asset('frontend/assets/images/logo/everlastlogo1.png')}}" alt="Logo" class="img-fluid" width="120">
                        </div>
                        <form method="POST" action="">
                            {!!csrf_field()!!}
                            @include('frontend._components.notification')
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password">
                                <small>
                                    <a href="">Forgot password?</a>
                                </small>
                            </div>
                            <div>
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" value="remember_me" name="remember_me">
                                    <span class="form-check-label">Remember me next time</span>
                                </label>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-lg btn-primary mb-2">Sign in</button>
                                <div>
                                    <small>Do you have an account? <a class="text-center" href="{{route('frontend.auth.register')}}">Sign Up</a></small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop