@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - Roles</h1>
</div>
@stop

@section('content')
@include('portal._components.notification')
<form method="POST" action="">
    {!!csrf_field()!!}
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4">
            <div class="card shadow mb-4 border-bottom-secondary">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Create Role</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="input_role">Name</label>
                        <input type="text" id="input_role" class="form-control" placeholder="Name" name="role" value="{{old('role')}}">
                        @if($errors->first('role'))
                        <small class="d-block mt-1 text-danger">{{$errors->first('role')}}</small>
                        @endif
                    </div>
                    <div class="form-group mb-4">
                        <label for="input_status">Status</label>
                        {!! html()->select('status', $statuses, old('status'), ['id' => "input_status"])->class('form-control') !!}
                        @if($errors->first('status'))
                        <small class="d-block mt-1 text-danger">{{$errors->first('status')}}</small>
                        @endif
                    </div>
                    <hr>
                    <a href="{{route('portal.cms.roles.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Create Role</button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-7 col-xl-8">
            <div class="card shadow mb-4 border-bottom-secondary">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Role Permissions</h6>
                </div>
                <div class="card-body">
                    @if($errors->first('permissions'))
                    <small class="d-block mt-1 text-danger">{{$errors->first('permissions')}}</small>
                    @endif
                    @foreach($permissions as $module_name => $perms)
                    <h6><b>{{$module_name}}</b></h6>
                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            class="form-check-input input-check-all"
                            id="check-all-{{$module_name}}"
                            data-module="{{$module_name}}"
                        >
                        <label class="form-check-label" for="check-all-{{$module_name}}">Check/Uncheck All</label>
                    </div>
                    <div class="row">
                        @foreach($perms as $permission)
                        <div class="col-sm-12 col-md-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input permission-checkbox"
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{$permission->name}}"
                                    id="permission-{{$permission->id}}"
                                    data-module="{{$module_name}}"
                                >
                                <label class="form-check-label" for="permission-{{$permission->name}}">{{$permission->description}}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>
@stop

@section('page-scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('change', '.input-check-all', function() {
            var is_checked = $(this).is(':checked');
            var module_name = $(this).data('module');

            $('input.permission-checkbox[data-module="' + module_name + '"]').prop('checked', is_checked);
        });
    });
</script>
@stop