@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Transactions</h1>
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
                        <input type="text" id="input_keyword" class="form-control" placeholder="eg. Booking Code, Event Name, Customer, Processor" name="keyword"  value="{{$keyword}}">
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
            <a href="{{route('portal.transactions.index')}}" class="btn btn-sm btn-secondary">Reset Filter</a>
        </form>
    </div>
</div>
<div class="card shadow mb-4 border-bottom-secondary">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Record Data</h6>
        @if($auth->canAny(['portal.transactions.export'], 'portal'))
        <div>
            <a href="{{route('portal.transactions.export')}}?keyword={{$keyword}}&start_date={{$start_date}}&end_date={{$end_date}}&type=pdf" class="btn btn-sm btn-danger">Export to PDF</a>
            <a href="{{route('portal.transactions.export')}}?keyword={{$keyword}}&start_date={{$start_date}}&end_date={{$end_date}}&type=excel" class="btn btn-sm btn-success">Export to Excel</a>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0">Code</th>
                        <th class="border-top-0">Event</th>
                        <th class="border-top-0">Customer</th>
                        <th class="border-top-0">Processor</th>
                        <th class="border-top-0 text-right">Price</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0">Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record as $index => $transaction)
                    <tr>
                        <td>{{$transaction->code}}</td>
                        <td>{{$transaction->event->name}}</td>
                        <td>{{$transaction->user->name}}</td>
                        <td>{{$transaction->processor->name}}</td>
                        <td class="text-right">₱ {{$transaction->event->price}}</td>
                        <td><span class="badge bg-{{Helper::booking_badge_status($transaction->status)}} text-white">{{$transaction->status}}</span>
                            <span class="badge bg-{{Helper::payment_badge_status($transaction->payment_status)}} text-white">{{$transaction->payment_status}}</span>
                        </td>
                        <td>{{Carbon::parse($transaction->created_at)->format('m/d/Y h:i A')}}</td>
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