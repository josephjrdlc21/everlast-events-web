@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - Roles</h1>
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
                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-4">
                    <div class="form-group">
                        <label for="input_keyword">Keyword</label>
                        <input type="text" id="input_keyword" class="form-control" placeholder="eg. User Role" name="keyword"  value="{{$keyword}}">
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-2 col-xl-3">
                    <div class="form-group">
                        <label for="input_user_status">Status</label>
                        {!! html()->select('status', $statuses, $selected_status, old('status'), ['id' => "input_user_status"])->class('form-control') !!}
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-4 col-xl-5">
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
            <a href="{{route('portal.cms.roles.index')}}" class="btn btn-sm btn-secondary">Reset Filter</a>
        </form>
    </div>
</div>
<div class="card shadow mb-4 border-bottom-secondary">
    <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Record Data</h6>
        @if($auth->canAny(['portal.cms.roles.create'], 'portal'))
        <a class="btn btn-sm btn-primary" href="{{route('portal.cms.roles.create')}}">Add User Role</a>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="border-top-0">No.</th>
                        <th class="border-top-0">User Role</th>
                        <th class="border-top-0 text-center">Total Access</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0">Date Added</th>
                        <th class="border-top-0">Last Modified</th>
                        <th class="border-top-0"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($record as $index => $role)
                    <tr>
                        <td>{{$loop->index + $record->firstItem()}}</td>
                        <td>
                            @if($auth->canAny(['portal.cms.roles.update'], 'portal'))
                            <a href="{{route('portal.cms.roles.edit', [$role->id])}}">{{Helper::capitalize_text($role->name)}}</a>
                            @else
                            <a href="#">{{Helper::capitalize_text($role->name)}}</a>
                            @endif
                        </td>
                        <td class="text-center">{{$role->permissions->count()}}</td>
                        <td><span class="badge badge-{{Helper::badge_status($role->status)}}">{{ Str::upper($role->status)}}</span></td>
                        <td>{{$role->created_at->format("m/d/Y")}}<br><small>{{$role->created_at->format("h:i A")}}</small></td>
                        <td>{{$role->updated_at->format("m/d/Y")}}<br><small>{{$role->updated_at->format("h:i A")}}</small></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton" style="">
                                    @if($auth->canAny(['portal.cms.roles.update'], 'portal'))
                                    <a class="dropdown-item" href="{{route('portal.cms.roles.edit', [$role->id])}}">Edit Details</a>
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