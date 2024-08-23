<html lang="en">
    <head>
        @include('portal._components.metas') 
        @include('portal._components.styles')
        @yield('page-styles')
    </head>
    <body class="d-flex align-items-center justify-content-center bg-light">
        <div class="container">
            <div class="row justify-content-center">
                @yield('content')
            </div>
        </div>
    </body>
    @include('portal._components.scripts')
    @yield('page-scripts')
</html>