@extends('frontend._layouts.main')

@section('breadcrumb')
<h1 class="h3 mb-3"><strong>Booking</strong></h1>
@stop

@section('content')
@include('frontend._components.notification')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Advance Filter</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row">
                        <div class="col-sm-12 col-lg-5">
                            <div class="form-group">
                                <label for="input_keyword">Keyword</label>
                                <input type="text" id="input_keyword" class="form-control" placeholder="eg. Booking Code, Event Name" name="keyword" value="{{$keyword}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="input_from">From</label>
                                        <input type="text" class="form-control date-picker" placeholder="YYYY-MM-DD" name="start_date" value="{{$start_date}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="input_from">To</label>
                                        <input type="text" class="form-control date-picker" placeholder="YYYY-MM-DD" name="end_date" value="{{$end_date}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary mt-4">Apply Filter</button>
                    <a href="{{route('frontend.bookings.index')}}" class="btn btn-sm btn-secondary mt-4">Reset Filter</a>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Record Data</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Code</th>
                                <th>Event</th>
                                <th class="text-right">Price</th>
                                <th>Status</th>
                                <th>Date Booked</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($record as $index => $booking)
                            <tr>
                                <td class="text-center "><div class="mt-2 mb-2">{{$loop->index + $record->firstItem()}}</div></td>
                                <td><a href="{{route('frontend.bookings.show', [$booking->id])}}">{{$booking->code}}</a></td>
                                <td>{{$booking->event->name}}</td>
                                <td class="text-right">₱ {{$booking->event->price}}</td>
                                <td><span class="badge bg-{{Helper::booking_badge_status($booking->status)}}">{{$booking->status}}</span>
                                    <span class="badge bg-{{Helper::payment_badge_status($booking->payment_status)}}">{{$booking->payment_status}}</span>
                                </td>
                                <td>{{Carbon::parse($booking->created_at)->format('m/d/Y h:i A')}}</td>
                                <td><a href="{{route('frontend.bookings.show', [$booking->id])}}" class="btn btn-sm btn-info">View Details</a></td>
                            </tr>
                            @empty
                            <td colspan="7">
                                <p class="text-center">No record found yet.</p>
                            </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($record->total() > 0)
                <div class="mt-4">
                    <div>Showing <strong>{{$record->firstItem()}}</strong> to <strong>{{$record->lastItem()}}</strong> of <strong>{{$record->total()}}</strong> entries</div>
                    @if($record->total() >= 10)<div id="pagination">{!!$record->appends(request()->query())->render()!!}</div>@endif
                </div>
                @endif
            </div>
        </div>
    </div>
<div>
@stop

@section('page-scripts')
<script type="text/javascript">
    $(function() {
        $('.date-picker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
</script>
@stop