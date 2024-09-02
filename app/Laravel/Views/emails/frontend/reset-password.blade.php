@extends('emails._layouts.main')

@section('content')
<h4>Reset Password</h4>
<p>Click the link below to reset you password!</p>
<a href="{{route('frontend.auth.reset_password', [$token])}}">Link to Reset Password</a>
@stop
