@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Audit Trail</h1>
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
                        <input type="text" id="input_keyword" class="form-control" placeholder="eg. Username, Remarks" name="keyword"  value="{{$keyword}}">
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
            <a href="{{route('portal.audit_trail.index')}}" class="btn btn-sm btn-secondary">Reset Filter</a>
        </form>
    </div>
</div>
<div class="card shadow mb-4 border-bottom-secondary">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Record Data</h6>
        @if($auth->canAny(['portal.audit_trail.export'], 'portal'))
        <div>
            <a href="{{route('portal.audit_trail.export')}}?keyword={{$keyword}}&start_date={{$start_date}}&end_date={{$end_date}}&type=pdf" class="btn btn-sm btn-danger">Export to PDF</a>
            <a href="{{route('portal.audit_trail.export')}}?keyword={{$keyword}}&start_date={{$start_date}}&end_date={{$end_date}}&type=excel" class="btn btn-sm btn-success">Export to Excel</a>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0">No.</th>
                        <th class="border-top-0">Name</th>
                        <th class="border-top-0">IP Adress</th>
                        <th class="border-top-0">Action</th>
                        <th class="border-top-0">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record as $index => $audit_trail)
                    <tr>
                        <td>{{$loop->index + $record->firstItem()}}</td>
                        <td>{{$audit_trail->user->name}}<br><small>{{Helper::capitalize_text($audit_trail->user->roles->pluck('name')->implode(',')) ?? ''}}</small></td>
                        <td>{{$audit_trail->ip}}</td>
                        <td>{{$audit_trail->remarks}}</td>
                        <td>{{$audit_trail->created_at->format("m/d/Y h:i A")}}<br><small class="text-white">x</small></td>
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