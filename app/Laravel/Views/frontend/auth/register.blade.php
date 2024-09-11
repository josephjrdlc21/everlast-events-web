@extends('frontend._layouts.auth')

@section('content')
<div class="row vh-100">
    <div class="col-sm-10 col-md-8 col-lg-7 mx-auto d-table h-100">
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
                        <form method="POST" action="">
                            {!!csrf_field()!!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Firstname</label>
                                        <input class="form-control form-control-lg" type="text" name="firstname" placeholder="Firstname" value="{{old('firstname')}}">
                                        @if($errors->first('firstname'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('firstname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Middlename</label>
                                        <input class="form-control form-control-lg" type="text" name="middlename" placeholder="Middlename" value="{{old('middlename')}}">
                                        @if($errors->first('middlename'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('middlename')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Lastname</label>
                                        <input class="form-control form-control-lg" type="text" name="lastname" placeholder="Lastname" value="{{old('lastname')}}">
                                        @if($errors->first('lastname'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('lastname')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Suffix</label>
                                        <input class="form-control form-control-lg" type="text" name="suffix" placeholder="Suffix" value="{{old('suffix')}}">
                                        @if($errors->first('suffix'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('suffix')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Contact No.</label>
                                        <input class="form-control form-control-lg" type="text" name="contact" placeholder="+63" value="{{old('contact')}}">
                                        @if($errors->first('contact'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('contact')}}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control form-control-lg" type="email" name="email" placeholder="Email" value="{{old('email')}}">
                                        @if($errors->first('email'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('email')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password" placeholder="Password" value="{{old('password')}}">
                                        @if($errors->first('password'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('password')}}</small>
                                        @endif
                                        <small>
                                            <a href="{{route('frontend.auth.login')}}">Already have an account? Sign in</a>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password_confirmation" placeholder="Confirm Password" value="{{old('password_confirmation')}}">
                                        @if($errors->first('password_confirmation'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('password_confirmation')}}</small>
                                        @endif
                                    </div>
                                </div>
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