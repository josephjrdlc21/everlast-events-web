@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Events</h1>
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
                        <h6 class="m-0 font-weight-bold text-primary">Events Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-center mt-2 mb-5">{{$event->name}}</h3>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center align-items-center">
                                <div class="img-wrapper" style="width: 400px;">
                                    <img src="{{"{$event->directory}/{$event->filename}"}}" alt="Sponsor Logo" class="img-fluid rounded"> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p>Code: {{$event->code}}</p>
                                <p>Category: {{$event->category->title}}</p>
                                <p>Sponsor: {{$event->sponsor->name}}</p>
                                <p>Is Cancelled: <span class="badge badge-{{Helper::is_cancelled_badge_status($event->is_cancelled)}}">{{$event->is_cancelled ? 'Yes' : 'No'}}</span></p>
                                <p>Location: {{$event->location}}</p>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="text-justify">{!!$event->description!!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mb-3 ml-1">
                <div class="col-12">
                    <a href="{{route('portal.events.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    @if($auth->canAny(['portal.events.update'], 'portal'))
                    <a href="{{route('portal.events.edit', [$event->id])}}" class="btn btn-sm btn-warning">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop