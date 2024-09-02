@extends('frontend._layouts.auth')

@section('content')
<div class="row vh-100">
    <div class="col-sm-10 col-md-8 col-lg-5 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">
            <div class="text-center mt-4">
                <h1 class="h2">Reset Password</h1>
                <p class="lead">
                    Enter your new password
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
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password" placeholder="Password">
                                        @if($errors->first('password'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('password')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password_confirmation" placeholder="Confirm Password">
                                        @if($errors->first('password_confirmation'))
                                        <small class="d-block mt-1 text-danger">{{$errors->first('password_confirmation')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop