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
                Booking Details
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Booking ID</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->code}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Event</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->event->name}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Event Code</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->event->code}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Status</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <span class="badge bg-{{Helper::booking_badge_status($booking->status)}}">{{$booking->status}}</span>
                            <span class="badge bg-{{Helper::payment_badge_status($booking->payment_status)}}">{{$booking->payment_status}}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><b>My Remarks</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->client_remarks}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Admin Remarks</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->admin_remarks ?? 'N/A'}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Name</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->user->name}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Processor</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->processor->name ?? 'N/A'}}</p>
                    </div>
                </div>
                <hr>
                <a href="{{route('frontend.bookings.index')}}" class="btn btn-sm btn-secondary">Close</a>
                <a href="" class="btn btn-sm btn-info">Print Receipt</a>
                <button class="btn btn-sm btn-danger btn-cancel" data-url="{{route('frontend.bookings.update_status', [$booking->id])}}" 
                    {{$booking->status === 'cancelled' ? 'disabled' : ''}}>{{$booking->status === 'cancelled' ? 'Booking Cancelled' : 'Cancel Booking'}}
                </button>
            </div>
        </div>
    </div>
</div>
@stop

@section('page-scripts')
<script type="text/javascript">
	$(".btn-cancel").on('click', function(){
		var url = $(this).data('url');

		Swal.fire({
            title: 'Do you want to cancel this booking ?',
            icon: 'question',
			showCancelButton: true,
			showLoaderOnConfirm: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes',
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = url;
			}
		})
	});
</script>
@stop