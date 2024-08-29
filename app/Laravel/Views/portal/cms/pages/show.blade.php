@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - Pages</h1>
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
                        <h6 class="m-0 font-weight-bold text-primary">{{Helper::capitalize_text($page->type)}} Details</h6>
                    </div>
                    <div class="card-body">
                        <h3>{{$page->title}}</h3>
                        <div class="mt-3">{!!$page->content!!}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3 ml-1">
                <div class="col-12">
                    <a href="{{route('portal.cms.pages.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    @if($auth->canAny(['portal.cms.pages.update'], 'portal'))
                    <a href="{{route('portal.cms.pages.edit', [$page->id])}}" class="btn btn-sm btn-warning">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop