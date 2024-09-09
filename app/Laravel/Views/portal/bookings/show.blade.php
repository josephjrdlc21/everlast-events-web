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
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><b>Booking ID</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->code}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Customer Name</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->user->name}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Event</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->event->name}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Price</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>₱ {{$booking->event->price}}</p>
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
                            <span class="badge bg-{{Helper::booking_badge_status($booking->status)}} text-white">{{$booking->status}}</span>
                            <span class="badge bg-{{Helper::payment_badge_status($booking->payment_status)}} text-white">{{$booking->payment_status}}</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Customer Remarks</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->client_remarks}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>My Remarks</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->admin_remarks ?? 'N/A'}}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Process By</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>{{$booking->processor->name ?? 'N/A'}}</p>
                    </div>
                </div>
                <hr>
                <a href="{{route('portal.bookings.index')}}" class="btn btn-sm btn-secondary">Close</a>
                @if($auth->canAny(['portal.bookings.update_status'], 'portal'))
                    @if($booking->status === "pending")
                    <a href="{{route('portal.bookings.edit_status', ['id' => $booking->id, 'status' => 'approved'])}}" class="btn btn-sm btn-success">Approve Booking</a>
                    @endif
                @endif
                @if($auth->canAny(['portal.bookings.update_status'], 'portal'))
                    @if($booking->status === "pending")
                    <a href="{{route('portal.bookings.edit_status', ['id' => $booking->id, 'status' => 'cancelled'])}}" class="btn btn-sm btn-danger">Cancel Booking</a>
                    @endif
                @endif
                @if($auth->canAny(['portal.bookings.update_payment'], 'portal'))
                    @if($booking->status === "approved")
                    <button data-url="{{route('portal.bookings.update_payment', [$booking->id])}}" class="btn btn-sm btn-info btn-payment" {{$booking->payment_status === 'paid' ? 'disabled' : ''}}>
                        {{$booking->payment_status === 'unpaid' ? 'Confirm Payment' : 'Paid'}}
                    </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('page-scripts')
<script type="text/javascript">
	$(".btn-payment").on('click', function(){
		var url = $(this).data('url');

		Swal.fire({
            title: 'Click yes if the payment has been paid !',
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