@extends('frontend._layouts.auth')

@section('content')
<div class="row vh-100">
    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
                <h1 class="h2">Get started</h1>
                <p class="lead">
                    Start creating your account and start your booking!
                </p>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="m-sm-4">
                        <div class="text-center">
                            <img src="{{asset('frontend/assets/images/logo/everlastlogo1.png')}}" alt="Logo" class="img-fluid" width="120">
                        </div>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input class="form-control form-control-lg" type="text" name="name" placeholder="Enter your name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Company</label>
                                <input class="form-control form-control-lg" type="text" name="company" placeholder="Enter your company name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password">
                                <small>
                                    <a href="{{route('frontend.auth.login')}}">Already have an account? Sign in</a>
                                </small>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-lg btn-primary">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop