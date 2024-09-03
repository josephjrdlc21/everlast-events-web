@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - Settings</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Settings</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_brand">Brand</label>
                                <input type="text" id="input_brand" class="form-control" placeholder="Brand Name" name="brand" value="{{$settings->brand_name}}">
                                @if($errors->first('brand'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('brand')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_system">System</label>
                                <input type="text" id="input_system" class="form-control" placeholder="System Name" name="system" value="{{$settings->system_name}}">
                                @if($errors->first('system'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('system')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_logo">Upload/Change Logo</label>
                                <input class="form-control pb-5" type="file" id="input_logo" name="logo">
                                @if($errors->first('logo'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('logo')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('portal.cms.settings.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop