@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Members</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-8 col-lg-6 col-xl-4">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Reset Member Password</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    {!!csrf_field()!!}
                    <div class="form-group">
                        <label for="input_password">Password</label>
                        <input type="password" id="input_password" class="form-control" placeholder="Enter Password" name="password">
                        @if($errors->first('password'))
                        <small class="d-block mt-1 text-danger">{{$errors->first('password')}}</small>
                        @endif
                    </div>
                    <div class="form-group mb-4">
                        <label for="input_password_confirmation">Confirm Password</label>
                        <input type="password" id="input_password_confirmation" class="form-control" placeholder="Enter Password" name="password_confirmation">
                    </div>
                    <hr>
                    <a href="{{route('portal.members.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop