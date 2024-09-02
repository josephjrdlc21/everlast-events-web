@extends('portal._layouts.auth')

@section('content')
<div class="col-lg-12 col-md-10">
    <div class="card o-hidden border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img src="{{asset('assets/images/logo/everlastlogo1.png')}}" width="255" height="220" alt="Logo">
                </div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Everlast Portal Register</h1>
                        </div>
                        <form class="user" method="POST" action="">
                            @include('portal._components.notification')
                            {!!csrf_field()!!}
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="input_firstname" placeholder="First Name" name="firstname" value="{{old('firstname')}}">
                                    @if($errors->first('firstname'))
                                    <small class="d-block mt-1 text-danger">{{$errors->first('firstname')}}</small>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="input_lastname" placeholder="Last Name" name="lastname" value="{{old('lastname')}}">
                                    @if($errors->first('lastname'))
                                    <small class="d-block mt-1 text-danger">{{$errors->first('lastname')}}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="input_middlename" placeholder="Middle Name" name="middlename" value="{{old('middlename')}}">
                                    @if($errors->first('middlename'))
                                    <small class="d-block mt-1 text-danger">{{$errors->first('middlename')}}</small>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="input_suffix" placeholder="Suffix" name="suffix" value="{{old('suffix')}}">
                                    @if($errors->first('suffix'))
                                    <small class="d-block mt-1 text-danger">{{$errors->first('suffix')}}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="email" class="form-control form-control-user" id="input_email" placeholder="Email Address" name="email" value="{{old('email')}}">
                                    @if($errors->first('email'))
                                    <small class="d-block mt-1 text-danger">{{$errors->first('email')}}</small>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-user" id="input_contact" placeholder="+63" name="contact" value="{{old('contact')}}">
                                    @if($errors->first('contact'))
                                    <small class="d-block mt-1 text-danger">{{$errors->first('contact')}}</small>
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{route('portal.auth.login')}}">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop