@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Account Management</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_role">Role<span class="text-danger">*</span></label>
                                {!! html()->select('role', $roles, $user->roles->pluck('name')->first() ?? '', ['id' => 'input_role'])->class('form-control') !!}
                                @if($errors->first('role'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('role')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_firstname">First Name<span class="text-danger">*</span></label>
                                <input type="text" id="input_firstname" class="form-control" placeholder="First Name" name="firstname"  value="{{$user->firstname}}">
                                @if($errors->first('firstname'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('firstname')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_middlename">Middle Name</label>
                                <input type="text" id="input_middlename" class="form-control" placeholder="Middle Name" name="middlename" value="{{$user->middlename}}">
                                @if($errors->first('middlename'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('middlename')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_lastname">Last Name<span class="text-danger">*</span></label>
                                <input type="text" id="input_lastname" class="form-control" placeholder="Last Name" name="lastname" value="{{$user->lastname}}">
                                @if($errors->first('lastname'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('lastname')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_suffix">Suffix</label>
                                <input type="text" id="input_suffix" class="form-control" placeholder="Suffix" name="suffix" value="{{$user->suffix}}">
                                @if($errors->first('suffix'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('suffix')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_email">Email<span class="text-danger">*</span></label>
                                <input type="email" id="input_email" class="form-control" placeholder="Email" name="email" value="{{$user->email}}">
                                @if($errors->first('email'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('email')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_status">Status<span class="text-danger">*</span></label>
                                {!! html()->select('status', $statuses, value($user->status), ['id' => "input_status"])->class('form-control') !!}
                                @if($errors->first('status'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('status')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_contact">Contact No.<span class="text-danger">*</span></label>
                                <input type="text" id="input_contact" class="form-control" placeholder="+63" name="contact" value="{{$user->contact_number}}">
                                @if($errors->first('contact'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('contact')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('portal.users.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop