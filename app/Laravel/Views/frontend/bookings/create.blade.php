@extends('frontend._layouts.main')

@section('breadcrumb')
<h1 class="h3 mb-3"><strong>Bookings</strong></h1>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('frontend._components.notification')
        <div class="card">
            <div class="card-header">
                Book This Event
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <input type="text" id="input_id" class="form-control" name="event_id"  value="{{$event->id}}" hidden>
                            <div class="form-group">
                                <label for="input_code">Event Code</label>
                                <input type="text" id="input_code" class="form-control" placeholder="Event Code" name="code"  value="{{$event->code}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <div class="form-group">
                                <label for="input_name">Event Name</label>
                                <input type="text" id="input_name" class="form-control" placeholder="Event Name" name="name"  value="{{$event->name}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_remarks">Reason/Remarks</label>
                                <input type="text" id="input_remarks" class="form-control" placeholder="Remarks" name="remarks"  value="{{old('remarks')}}">
                                @if($errors->first('remarks'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('remarks')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('frontend.events.show', [$event->id])}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop