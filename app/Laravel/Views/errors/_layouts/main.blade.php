<html lang="en">
    <head>
        @include('errors._components.metas') 
        @include('errors._components.styles')
    </head>
    <body class="d-flex align-items-center justify-content-center">
        <div class="container-fluid">
            @yield('content')
        </div>
    </body>
    @include('errors._components.scripts')
</html>