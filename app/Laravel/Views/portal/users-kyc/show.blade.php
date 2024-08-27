@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Registrations</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Registrant Details</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-2">
                            <h6><b>Firstname</b></h6>
                            <p>{{$registrant->firstname}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Middlename</b></h6>
                            <p>{{$registrant->middlename ?: 'N/A'}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Lastname</b></h6>
                            <p>{{$registrant->lastname}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Suffix</b></h6>
                            <p>{{$registrant->suffix ?: 'N/A'}}</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="mb-2">
                            <h6><b>Email</b></h6>
                            <p>{{$registrant->email}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Contact No.</b></h6>
                            <p>{{$registrant->contact_number}}</p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Status</b></h5>
                            <p><span class="badge badge-{{Helper::registration_badge_status($registrant->status)}}">{{Str::upper($registrant->status)}}</span></p>
                        </div>
                        <div class="mb-2">
                            <h6><b>Date Registered</b></h6>
                            <p>{{$registrant->created_at->format("m/d/Y h:i A")}}</p>
                        </div>
                    </div>
                </div>
                <hr>
                <a href="{{route('portal.users_kyc.index')}}" class="btn btn-sm btn-secondary">Close</a>
                @if($registrant->status === 'pending')
                <button data-url="{{route('portal.users_kyc.update_status', ['id' => $registrant->id, 'status' => 'approved'])}}" class="btn btn-sm btn-success btn-approve">Approve</button>
                <button data-url="{{route('portal.users_kyc.update_status', ['id' => $registrant->id, 'status' => 'rejected'])}}" class="btn btn-sm btn-danger btn-cancel">Reject</button>
                @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('page-scripts')
<script type="text/javascript">
	$(".btn-approve").on('click', function(){
		var url = $(this).data('url');

		Swal.fire({
            title: 'Do you want to approve this registration ?',
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

    $(".btn-cancel").on('click', function(){
		var url = $(this).data('url');

		Swal.fire({
            title: 'Do you want to reject this registration ?',
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