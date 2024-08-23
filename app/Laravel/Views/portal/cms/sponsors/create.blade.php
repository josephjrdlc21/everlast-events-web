@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - Sponsors</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create Sponsor</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_sponsor">Sponsor</label>
                                <input type="text" id="input_sponsor" class="form-control" placeholder="Sponsor" name="sponsor" value="{{old('sponsor')}}">
                                @if($errors->first('sponsor'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('sponsor')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_logo">Upload Logo</label>
                                <input class="form-control pb-5" type="file" id="input_logo" name="logo" value="{{old('logo')}}">
                                @if($errors->first('logo'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('logo')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('portal.cms.sponsors.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop