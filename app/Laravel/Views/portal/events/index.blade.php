@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">Events</h1>
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
                <div class="col-sm-12 col-lg-3">
                    <div class="form-group">
                        <label for="input_keyword">Keyword</label>
                        <input type="text" id="input_keyword" class="form-control" placeholder="eg. Code, Event" name="keyword"  value="{{$keyword}}">
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3">
                    <div class="form-group">
                        <label for="input_cancel">Cancelled</label>
                        {!! html()->select('cancel', $cancel, $selected_cancel, old('cancel'), ['id' => "input_cancel"])->class('form-control') !!}
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
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
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="input_category">Category</label>
                        {!! html()->select('category', $categories, $selected_category, old('category'), ['id' => "input_category"])->class('form-control') !!}
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="input_sponsor">Sponsor</label>
                        {!! html()->select('sponsor', $sponsors, $selected_sponsor, old('sponsor'), ['id' => "input_sponsor"])->class('form-control') !!}
                    </div>
                </div>
            </div> 
            <button type="submit" class="btn btn-sm btn-primary">Apply Filter</button>
            <a href="{{route('portal.events.index')}}" class="btn btn-sm btn-secondary">Reset Filter</a>
        </form>
    </div>
</div>
<div class="card shadow mb-4 border-bottom-secondary">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Record Data</h6>
        @if($auth->canAny(['portal.events.create'], 'portal'))
        <a class="btn btn-sm btn-primary" href="{{route('portal.events.create')}}">Create Event</a>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0">Event</th>
                        <th class="border-top-0">Category/Sponsor</th>
                        <th class="border-top-0">Cancelled</th>
                        <th class="border-top-0">Start At</th>
                        <th class="border-top-0">Date Created</th>
                        <th class="border-top-0"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record as $index => $event)
                    <tr>
                        <td>
                            @if($auth->canAny(['portal.events.view'], 'portal'))
                            <a href="{{route('portal.events.show', [$event->id])}}">{{$event->code}}</a><br>{{$event->name}}
                            @else
                            <a href="#">{{$event->code}}</a><br>{{$event->name}}
                            @endif
                        </td>
                        <td>{{$event->category->title}}<br>{{$event->sponsor->name}}</td>
                        <td>
                            <small><span class="text-white badge bg-{{Carbon::parse($event->event_end)->lt(Carbon::now()) ? 'secondary' : 'success'}}">{{Carbon::parse($event->event_end)->lt(Carbon::now()) ? 'Unavailable' : 'Available'}}</span><br>
                            <span class="mt-1 badge badge-{{Helper::is_cancelled_badge_status($event->is_cancelled)}}">{{$event->is_cancelled ? 'Cancelled' : 'Start'}}</span><small>
                        </td>
                        <td>{{Carbon::parse($event->event_start)->format('m/d/Y')}} - {{Carbon::parse($event->event_end)->format('m/d/Y')}}<br><small>{{$event->location}}</small></td>                        
                        <td>{{Carbon::parse($event->created_at)->format('m/d/Y')}}<br><small>{{ Carbon::parse($event->created_at)->format('g:i A')}}</small></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                    @if($auth->canAny(['portal.events.view'], 'portal'))
                                    <a class="dropdown-item" href="{{route('portal.events.show', [$event->id])}}">View Details</a>
                                    @endif
                                    @if($auth->canAny(['portal.events.update'], 'portal'))
                                    <a class="dropdown-item" href="{{route('portal.events.edit', [$event->id])}}">Edit Details</a>
                                    @endif
                                    @if($auth->canAny(['portal.events.update_is_cancelled'], 'portal'))
                                    <a class="dropdown-item btn-activation" data-url="{{route('portal.events.update_is_cancelled', [$event->id])}}" data-status="{{$event->is_cancelled ? 'Yes' : 'No'}}" type="button">Cancel Event</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <td colspan="6">
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
    $(".btn-activation").on('click', function(){
		var url = $(this).data('url');
        var status = $(this).data('status');

		Swal.fire({
            title: status === 'Yes' ? 'Do you want to uncancel this event?' : 'Are you sure you want to cancel this event?',
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