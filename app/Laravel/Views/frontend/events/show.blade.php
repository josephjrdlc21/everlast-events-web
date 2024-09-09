@extends('frontend._layouts.main')

@section('breadcrumb')
<h1 class="h3 mb-3"><strong>Events</strong></h1>
@stop

@section('content')
@include('frontend._components.notification')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Event Details
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
                        <p>Price: ₱ {{$event->price}}</p>
                        <p>Status: 
                            <span class="badge bg-{{Carbon::parse($event->event_end)->lt(Carbon::now()) ? 'secondary' : 'success'}}">{{Carbon::parse($event->event_end)->lt(Carbon::now()) ? 'Unavailable' : 'Available'}}</span>
                            <span class="badge bg-{{Helper::is_cancelled_badge_status($event->is_cancelled)}}">{{$event->is_cancelled ? 'Cancelled' : 'Start'}}</span>
                        </p>
                        <p>Location: {{$event->location}}</p>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div>{!!$event->description!!}</div>
                    </div>
                </div>
                <hr>
                <div class="row mb-3 ml-1">
                    <div class="col-12">
                        <a href="{{route('frontend.events.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                        @if(!Carbon::parse($event->event_end)->lt(Carbon::now()))
                        <a href="{{route('frontend.bookings.create', [$event->id])}}" class="btn btn-sm btn-primary">Book Now</a>
                        @else
                        <button class="btn btn-sm btn-warning" disabled>Booking Is Not Available</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop