@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Booking Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_code">Booking Code</label>
                                <input type="text" id="input_code" class="form-control" placeholder="Booking Code" name="code"  value="{{$booking->code}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="input_user_name">Customer Name</label>
                                <input type="text" id="input_user_name" class="form-control" placeholder="Customer Name" name="customer_name"  value="{{$booking->user->name}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="input_event_name">Event Name</label>
                                <input type="text" id="input_event_name" class="form-control" placeholder="Event Name" name="event_name"  value="{{$booking->event->name}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="input_remarks">Remarks</label>
                                <input type="text" id="input_remarks" class="form-control" placeholder="Remarks" name="remarks"  value="{{old('remarks')}}">
                                @if($errors->first('remarks'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('remarks')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('portal.bookings.show', [$booking->id])}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop