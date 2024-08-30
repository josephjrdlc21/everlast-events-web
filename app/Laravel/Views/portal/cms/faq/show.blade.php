@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - FAQ</h1>
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
                        <h6 class="m-0 font-weight-bold text-primary">FAQ Details</h6>
                    </div>
                    <div class="card-body">
                        <h5>{{$faq->question}}</h5>
                        <div class="mt-3">{!!$faq->answer!!}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3 ml-1">
                <div class="col-12">
                    <a href="{{route('portal.cms.faq.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    @if($auth->canAny(['portal.cms.faq.update'], 'portal'))
                    <a href="{{route('portal.cms.faq.edit', [$faq->id])}}" class="btn btn-sm btn-warning">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop