<html lang="en">
    <head>
        @include('emails._components.metas') 
        @include('emails._components.styles')
    </head>
    <body>
        <h3>{{$settings->system_name ?? 'Events System'}}</h3>
        @yield('content')
    </body>
</html>