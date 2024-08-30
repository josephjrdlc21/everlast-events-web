@extends('portal._layouts.main')

@section('breadcrumb')
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800">CMS - FAQ</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        @include('portal._components.notification')
        <div class="card shadow mb-4 border-bottom-secondary">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create FAQ</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_question">Question</label>
                                <input type="text" id="input_question" class="form-control" placeholder="Question" name="question" value="{{old('question')}}">
                                @if($errors->first('question'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('question')}}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="input_answer">Answer</label>
                                <textarea id="editor" name="answer" class="form-control" placeholder="Your text here.">{{old('answer')}}</textarea>
                                @if($errors->first('answer'))
                                <small class="d-block mt-1 text-danger">{{$errors->first('answer')}}</small>
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
                    <a href="{{route('portal.cms.faq.index')}}" class="btn btn-sm btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop