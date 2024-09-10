@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Members</h1>
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
                <div class="col-sm-12 col-lg-4">
                    <div class="form-group">
                        <label for="input_keyword">Keyword</label>
                        <input type="text" id="input_keyword" class="form-control" placeholder="eg. Member ID, Name" name="keyword"  value="{{$keyword}}">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="form-group">
                        <label for="input_user_status">Status</label>
                        {!! html()->select('status', $statuses, $selected_status, old('status'), ['id' => "input_user_status"])->class('form-control') !!}
                    </div>
                </div>
                <div class="col-sm-12 col-lg-5">
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
            <button type="submit" class="btn btn-sm btn-primary">Apply Filter</button>
            <a href="{{route('portal.members.index')}}" class="btn btn-sm btn-secondary">Reset Filter</a>
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
                        <th class="border-top-0">Member</th>
                        <th class="border-top-0">Date Created</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0">Last Login</th>
                        <th class="border-top-0"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record as $index => $member)
                    <tr>
                        <td>
                            @if($auth->canAny(['portal.members.view'], 'portal'))
                            <a href="{{route('portal.members.show', [$member->id])}}">{{str_pad($member->id, 5, "0", STR_PAD_LEFT)}}</a><br>
                            @else
                            <a href="#">{{str_pad($member->id, 5, "0", STR_PAD_LEFT)}}</a><br>
                            @endif
                            <div>{{$member->name}}</div>
                        </td>
                        <td>{{$member->created_at->format("m/d/Y h:i A")}}</td>
                        <td><span class="badge badge-{{Helper::badge_status($member->status)}}">{{Str::upper($member->status)}}</span></td>
                        <td>{{$member->last_login_at ? Carbon::parse($member->last_login_at)->format("m/d/Y h:i A") : "Not Logged In Yet"}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                    @if($auth->canAny(['portal.members.view'], 'portal'))
                                    <a class="dropdown-item" href="{{route('portal.members.show', [$member->id])}}">View Details</a>
                                    @endif
                                    @if($auth->canAny(['portal.members.edit_password'], 'portal'))
                                    <a class="dropdown-item" href="{{route('portal.members.edit_password', [$member->id])}}">Reset Password</a>
                                    @endif
                                    @if($auth->canAny(['portal.members.update_status'], 'portal'))
                                    <a class="dropdown-item btn-activation" data-url="{{route('portal.members.update_status', [$member->id])}}" data-status="{{$member->status}}" type="button">{{$member->status == 'active' ? 'Deactivate Account' : 'Activate Account'}}</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <td colspan="5">
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

	$(".btn-activation").on('click', function(){
		var url = $(this).data('url');
        var status = $(this).data('status');

		Swal.fire({
            title: status === 'active' ? 'Are you sure you want to deactivate this account?' : 'Are you sure you want to activate this account?',
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