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
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Event</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_image">Change Event Image</label>
                                <input class="form-control pb-5" type="file" id="input_image" name="event_image">
                                @if($errors->first('event_image'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('event_image')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="input_event">Event Name</label>
                                <input type="text" id="input_event" class="form-control" placeholder="Enter Event" name="event"  value="{{$event->name}}">
                                @if($errors->first('event'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('event')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="input_category">Category</label>
                                {!! html()->select('category', $categories, value($event->category_id), ['id' => 'input_category'])->class('form-control') !!}
                                @if($errors->first('category'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('category')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="input_sponsor">Sponsor</label>
                                {!! html()->select('sponsor', $sponsors, value($event->sponsor_id), ['id' => 'input_sponsor'])->class('form-control') !!}
                                @if($errors->first('sponsor'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('sponsor')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_description">Description</label>
                                <textarea id="editor" name="description" class="form-control" placeholder="Your text here.">{{$event->description}}</textarea>
                                @if($errors->first('description'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('description')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_location">Location</label>
                                <input type="text" id="input_location" class="form-control" placeholder="Enter Location" name="location"  value="{{$event->location}}">
                                @if($errors->first('location'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('location')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_start">Event Start</label>
                                <input type="datetime-local" class="form-control" name="start_date" value="{{Carbon::parse($event->event_start)->format('Y-m-d')}}">
                                @if($errors->first('start_date'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('start_date')}}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_end">Event End</label>
                                <input type="datetime-local" class="form-control" name="end_date" value="{{Carbon::parse($event->event_end)->format('Y-m-d')}}">
                                @if($errors->first('end_date'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('end_date')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('portal.events.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop