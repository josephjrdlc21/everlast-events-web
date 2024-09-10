@extends('frontend._layouts.main')

@section('breadcrumb')
<h1 class="h3 mb-3"><strong>Events</strong></h1>
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
                        <div class="col-sm-12 col-lg-4">
                            <div class="form-group">
                                <label for="input_keyword">Keyword</label>
                                <input type="text" id="input_keyword" class="form-control" placeholder="eg. Events Code, Name" name="keyword"  value="{{$keyword}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3">
                            <div class="form-group">
                                <label for="input_category">Category</label>
                                {!! html()->select('category', $categories, $selected_category, old('category'), ['id' => "input_category"])->class('form-control') !!}
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
                    <button type="submit" class="btn btn-sm btn-primary mt-4">Apply Filter</button>
                    <a href="{{route('frontend.events.index')}}" class="btn btn-sm btn-secondary mt-4">Reset Filter</a>
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
                                <th>Event</th>
                                <th>Category</th>
                                <th class="text-right">Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($record as $index => $event)
                            <tr>
                                <td class="text-center"><div class="mt-2 mb-2">{{$loop->index + $record->firstItem()}}</div></td>
                                <td><a href="{{route('frontend.events.show', [$event->id])}}">{{$event->code}}</a><br><small>{{$event->name}}</small></td>
                                <td>{{$event->category->title}}<br><small>{{$event->sponsor->name}}</small></td>
                                <td class="text-right">₱ {{$event->price}}</td>
                                <td>
                                    <small><span class="badge bg-{{Carbon::parse($event->event_end)->lt(Carbon::now()) ? 'secondary' : 'success'}}">{{Carbon::parse($event->event_end)->lt(Carbon::now()) ? 'Unavailable' : 'Available'}}</span><br>
                                    <span class="mt-1 badge bg-{{Helper::is_cancelled_badge_status($event->is_cancelled)}}">{{$event->is_cancelled ? 'Cancelled' : 'Start'}}</span></small>
                                </td>
                                <td>{{Carbon::parse($event->event_start)->format('m/d/Y')}} - {{Carbon::parse($event->event_end)->format('m/d/Y')}}<br><small>{{$event->location}}</small></td>
                                <td><a class="btn btn-sm btn-info" href="{{route('frontend.events.show', [$event->id])}}">View Details</a></td>
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
                    @if($record->total() >= 10)
                    <div id="pagination">{!!$record->appends(request()->query())->render()!!}</div>
                    @endif
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