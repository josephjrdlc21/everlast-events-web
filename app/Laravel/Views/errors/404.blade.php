@extends('errors._layouts.main')

@section('content')  
<div class="text-center">
    <div class="error mx-auto" data-text="404">404</div>
    <p class="lead text-gray-800 mb-5">Page Not Found</p>
    <p class="text-gray-500 mb-5">The page you're looking for might have been removed or is temporarily unavailable...</p>
    <a href="{{route('portal.index')}}">← Back to Home</a>
</div>
@stop