@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - Category</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="row">
                <div class="col-12">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Category Details <span class="badge badge-{{Helper::badge_status($category->status)}}">{{Str::upper($category->status)}}</span></h6>
                    </div>
                    <div class="card-body">
                        <h3>{{$category->title}}</h3>
                        <div class="mt-3">{!!$category->description!!}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3 ml-1">
                <div class="col-12">
                    <a href="{{route('portal.cms.category.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    @if($auth->canAny(['portal.cms.category.update'], 'portal'))
                    <a href="{{route('portal.cms.category.edit', [$category->id])}}" class="btn btn-sm btn-warning">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop