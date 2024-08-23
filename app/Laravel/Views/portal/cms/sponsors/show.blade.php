@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - Sponsors</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-8 col-lg-6 col-xl-4">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="row">
                <div class="col-12">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Sponsor Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center align-items-center">
                                <div class="img-wrapper" style="width: 280px;">
                                    <img src="{{"{$sponsor->directory}/{$sponsor->filename}"}}" alt="Sponsor Logo" class="img-fluid"> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="text-center"><b>Sponsor Name:</b></p>
                            </div>
                            <div class="col-md-12">
                                <p class="text-center">{{$sponsor->name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3 ml-1">
                <div class="col-12">
                    <a href="{{route('portal.cms.sponsors.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    @if($auth->canAny(['portal.cms.sponsors.update'], 'portal'))
                    <a href="{{route('portal.cms.sponsors.edit', [$sponsor->id])}}" class="btn btn-sm btn-warning">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop