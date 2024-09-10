@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rejected Registrations</h1>
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
                        <input type="text" id="input_keyword" class="form-control" placeholder="eg. Registration ID, Name" name="keyword"  value="{{$keyword}}">
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
            <button type="submit" class="btn btn-sm btn-primary">Apply Filter</button>
            <a href="{{route('portal.users_kyc.rejected')}}" class="btn btn-sm btn-secondary">Reset Filter</a>
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
                        <th class="border-top-0">Registrant</th>
                        <th class="border-top-0">Email</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0">Registration Date</th>
                        <th class="border-top-0"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record as $index => $registration)
                    <tr>
                        <td>
                            @if($auth->canAny(['portal.users_kyc.view'], 'portal'))
                            <a href="{{route('portal.users_kyc.show', [$registration->id])}}">{{str_pad($registration->id, 5, "0", STR_PAD_LEFT)}}</a><br>
                            @else
                            <a href="#">{{str_pad($registration->id, 5, "0", STR_PAD_LEFT)}}</a><br>
                            @endif
                            <div>{{$registration->name}}</div>
                        </td>
                        <td>{{$registration->email}}<br><small>{{$registration->contact_number}}</small></td>
                        <td><span class="badge badge-{{Helper::registration_badge_status($registration->status)}}">{{Str::upper($registration->status)}}</span></td>
                        <td>{{$registration->created_at->format("m/d/Y h:i A")}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                    @if($auth->canAny(['portal.users_kyc.view'], 'portal'))
                                    <a class="dropdown-item" href="{{route('portal.users_kyc.show', [$registration->id])}}">View Registration</a>
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
</script>
@stop