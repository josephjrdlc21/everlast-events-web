@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
</div>
@stop

@section('content')
@include('portal._components.notification')
<div class="card shadow mb-4 border-bottom-secondary">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Advance Filter</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="">
            <div class="row">
                <div class="col-sm-12 col-lg-5">
                    <div class="form-group">
                        <label for="input_keyword">Keyword</label>
                        <input type="text" id="input_keyword" class="form-control" placeholder="eg. Booking Code, Event Name" name="keyword"  value="{{$keyword}}">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-7">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_from">From</label>
                                <input type="date" class="form-control" name="start_date" value="{{$start_date}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="input_from">To</label>
                                <input type="date" class="form-control" name="end_date" value="{{$end_date}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <button type="submit" class="btn btn-sm btn-primary">Apply Filter</button>
            <a href="{{route('portal.bookings.index')}}" class="btn btn-sm btn-secondary">Reset Filter</a>
        </form>
    </div>
</div>
<div class="card shadow mb-4 border-bottom-secondary">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Record Data</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0 text-center">No.</th>
                        <th class="border-top-0">Code</th>
                        <th class="border-top-0">Event</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0">Date Booked</th>
                        <th class="border-top-0"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record as $index => $booking)
                    <tr>
                        <td class="text-center">{{$loop->index + $record->firstItem()}}</td>
                        @if($auth->canAny(['portal.bookings.view'], 'portal'))
                        <td><a href="{{route('portal.bookings.show', [$booking->id])}}">{{$booking->code}}</a></td>
                        @else
                        <td><a href="#">{{$booking->code}}</a></td>
                        @endif
                        <td>{{$booking->event->name}}</td>
                        <td><span class="badge bg-{{Helper::booking_badge_status($booking->status)}} text-white">{{$booking->status}}</span>
                            <span class="badge bg-{{Helper::payment_badge_status($booking->payment_status)}} text-white">{{$booking->payment_status}}</span>
                        </td>
                        <td>{{Carbon::parse($booking->created_at)->format('m/d/Y h:i A')}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                    @if($auth->canAny(['portal.bookings.view'], 'portal'))
                                    <a class="dropdown-item" href="{{route('portal.bookings.show', [$booking->id])}}">View Details</a>
                                    @endif
                                </div>
                            </div>
                        </td>
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
        <div class="mt-4 d-sm-flex align-items-center justify-content-between">
            <div>Showing <strong>{{$record->firstItem()}}</strong> to <strong>{{$record->lastItem()}}</strong> of <strong>{{$record->total()}}</strong> entries</div>
            <div class="pagination pagination-sm">{!!$record->appends(request()->query())->render()!!}</div>
        </div>
        @endif
    </div>
</div>
@stop