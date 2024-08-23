@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - Category</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create Category</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_title">Title</label>
                                <input type="text" id="input_title" class="form-control" placeholder="Title" name="title"  value="{{old('title')}}">
                                @if($errors->first('title'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('title')}}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_description">Description</label>
                                <textarea id="editor" name="description" class="form-control" placeholder="Your text here.">{{old('description')}}</textarea>
                                @if($errors->first('description'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('description')}}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_status">Status</label>
                                {!! html()->select('status', $statuses, old('status'), ['id' => "input_status"])->class('form-control') !!}
                                @if($errors->first('status'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('status')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <a href="{{route('portal.cms.category.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop