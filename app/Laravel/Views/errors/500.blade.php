@extends('errors._layouts.main')

@section('content')  
<div class="text-center">
    <div class="error mx-auto" data-text="500">500</div>
    <p class="lead text-gray-800 mb-5">Server Error</p>
    <p class="text-gray-500 mb-5">An unexpected error occurred. Please try again later...</p>
    <a href="{{route('portal.index')}}">← Back to Home</a>
</div>
@stop